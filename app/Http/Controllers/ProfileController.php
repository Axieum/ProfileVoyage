<?php

namespace App\Http\Controllers;

use App\Profile;
use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Resource constructor
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['checkLink', 'checkName']);
        $this->middleware('verified');
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
        //
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
        if (is_null($profile))
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
