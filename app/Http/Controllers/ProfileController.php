<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Rules\AlphaSpace;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    /**
     * Resource constructor
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['checkLink', 'checkName', 'show']);
        $this->middleware('verified')->except('show');
        $this->middleware('auth:api')->only(['checkLink', 'checkName']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('profile.index')->withProfiles(Auth::user()->profiles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateWith([
            'name' => ['required', 'string', 'min:1', 'max:16', 'alpha_dash', Rule::unique('profiles')->where(function ($query) {
                return $query->where('user_id', Auth::user()->id);
            })],
            'link' => 'required|string|min:3|max:32|alpha_dash',
            'displayName' => 'required|string|min:2|max:50',
            'motto' => 'sometimes|nullable|string|min:1|max:100',
            'dob_day' => 'required_with:dob_month,dob_year|integer|between:1,31',
            'dob_month' => 'required_with:dob_day,dob_year|integer|between:1,12',
            'dob_year' => 'required_with:dob_day,dob_month|integer|between:' . (date('Y') - 128) . ',' . date('Y'),
            'country' => 'sometimes|string|size:2|exists:countries,code',
            'location' => ['sometimes', 'nullable', 'string', 'max:32', new AlphaSpace],
            'avatar' => 'sometimes|nullable|file|mimes:jpeg,png,jpg'
        ]);

        // Date of birth workaround to support name in dropdown.
        $dob = null;
        if (isset($request->dob_day) && isset($request->dob_month) && isset($request->dob_year))
        {
            // Parse the supplied day/month/year into a suitable date string ready for database.
            $dob = date('Y-m-j', strtotime($request->dob_day . '-' . $request->dob_month . '-' . $request->dob_year));
        }

        $profile = Auth::user()->profiles()->create([
            'name' => $request->name,
            'link' => strtolower($request->link),
            'display_name' => $request->displayName,
            'motto' => $request->motto,
            'date_of_birth' => $dob,
            'location' => $request->location,
            'country' => (is_null($request->country) ? null : strtoupper($request->country)),
            'avatar' => null
        ]);

        if ($profile->save())
        {
            Session::flash('status', 'success');
            Session::flash('message', 'Successfully created a new profile! (' . $profile->name . ')');
            return redirect(route('profile.index'));
        }
        else
        {
            Session::flash('status', 'danger');
            Session::flash('message', 'An error occurred while creating your profile.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show($profileLink)
    {
        $profile = Profile::where('link', $profileLink)->first();

        if (is_null($profile) || !$profile->active)
            abort(404, 'Unfortunately, there is nothing here.');

        return view('profile.show')->withProfile($profile);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit($profileLink)
    {
        $profile = Profile::where('link', $profileLink)->first();
        if (is_null($profile))
            abort(404, 'Unfortunately, there is nothing here.');
        return view('profile.edit')->withProfile($profile);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $profileLink)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy($profileLink)
    {
        $profile = Profile::where('link', $profileLink)->first();

        if (is_null($profile))
            abort(404, 'A profile with the link ' . $profileLink . " couldn't be found.");

        if ($profile->delete())
        {
            Session::flash('status', 'success');
            Session::flash('message', 'The profile (' . $profileLink . ') has been destroyed.');
        }
        else
        {
            Session::flash('status', 'danger');
            Session::flash('message', 'Something prevented us from destroying the profile!');
        }

        return redirect(route('index'));
    }

    /**
     * Check the availability of a link request.
     *
     * @param Request $request
     * @return json
     */
    public function checkLink(Request $request)
    {
        return response()->json(!Profile::where('link', $request->value)->exists());
    }

    /**
     * Check the availability of a name request.
     *
     * @param Request $request
     * @return json
     */
    public function checkName(Request $request)
    {
        return response()->json(!Profile::where('user_id', Auth::user()->id)->where('name', $request->value)->exists());
    }
}
