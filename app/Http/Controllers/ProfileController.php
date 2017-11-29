<?php

namespace App\Http\Controllers;

use App\Profile;
use App\Social;
use App\Events\ProfileDeleted;
use App\Rules\AlphaSpace;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use LaraFlash;

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
        $this->middleware('throttle:3,1', ['only' => ['store', 'update']]);
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
            'link' => 'required|string|min:3|max:32|alpha_dash|unique:profiles',
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

        $profile = new Profile();
        $profile->user_id = Auth::user()->id;
        $profile->name = $request->name;
        $profile->link = strtolower($request->link);
        $profile->display_name = $request->displayName;
        $profile->motto = $request->motto;
        $profile->date_of_birth = $dob;
        $profile->location = $request->location;
        $profile->country = (is_null($request->country) ? null : strtoupper($request->country));
        // To protect mass profile image downloads, generate a random 30 character long string.
        $profile->avatar = bin2hex(openssl_random_pseudo_bytes(15));

        // Manipulate and save avatar.
        if (!is_null($request->avatar))
        {
            $img = Image::make($request->file('avatar'));
            $img->fit(512, 512, function($constraint) {
                $constraint->upsize();
            });
            if (is_null($img->save(storage_path('app/public/avatars/' . $profile->avatar . '.png'))))
            {
                LaraFlash::danger('An error occurred saving your profile image.');
                return redirect()->back()->withInput();
            }
        }

        if ($profile->save())
        {
            LaraFlash::success('Successfully created a new profile! (' . $profile->name . ')');
            return redirect(route('profile.show', $profile->link));
        }
        else
        {
            LaraFlash::danger('An error occurred while creating your profile.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $profileLink
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
     * @param  int  $profileLink
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $profileLink
     * @return \Illuminate\Http\Response
     */
    public function editLinks($profileLink)
    {
        $profile = Profile::where('link', $profileLink)->first();
        if (is_null($profile))
            abort(404, 'Unfortunately, there is nothing here.');
        $socials = Auth::user()->socials()->select('*', 'socials.id as id')->join('social_platforms', 'social_platforms.id', '=', 'socials.platform_id')->orderBy('social_platforms.display_name')->get();
        return view('profile.link')->withProfile($profile)->withSocials($socials);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $profileLink
     * @param int $socialId
     * @return \Illuminate\Http\Response
     */
    public function unlink(Request $request, $profileLink, $socialId)
    {
        $profile = Profile::where('link', $profileLink)->first();
        $social = Social::where('id', $socialId)->first();

        if (is_null($profile))
            abort(404, 'A profile with that link could not be found!');

        if (is_null($social))
            abort(404, 'That social account could not be found!');

        if ($profile->user_id != Auth::user()->id)
            abort(403, 'You do not have permission to edit this profile!');

        if ($social->user_id != Auth::user()->id)
            abort(403, 'You do not have permission to that social account!');

        $socialPlatform = $social->platform->display_name;

        if ($profile->socials()->detach($social))
        {
            LaraFlash::success('Successfully removed a ' . $socialPlatform . ' accout from this profile!');
            return redirect(route('profile.links', $profile->link));
        }
        else
        {
            LaraFlash::danger('Unable to remove that social account from this profile! Try again later.');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $profileLink
     * @return \Illuminate\Http\Response
     */
    public function link(Request $request, $profileLink)
    {
        $profile = Profile::where('link', $profileLink)->first();

        if (is_null($profile))
            abort(404, 'A profile with that link could not be found!');

        $this->validateWith([
            'social_id' => 'required|integer'
        ]);
        $social = Social::where('id', $request->social_id)->first();

        if (is_null($social))
            abort(404, 'That social account could not be found!');

        if ($profile->user_id != Auth::user()->id)
            abort(403, 'You do not have permission to edit this profile!');

        if ($social->user_id != Auth::user()->id)
            abort(403, 'You do not have permission to that social account!');

        if ($profile->socials()->attach($social))
        {
            LaraFlash::success('Successfully added a new social accout to this profile!');
            return redirect(route('profile.links', $profile->link));
        }
        else
        {
            LaraFlash::danger('Unable to add that social account to this profile! Try again later.');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $profileLink
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $profileLink)
    {
        $profile = Profile::where('link', $profileLink)->first();

        // Does the profile exist?
        if (is_null($profile))
            abort(404, 'A profile with that link couldn\'t be found! (' . $profileLink . ')');

        // Does the currently authenticated user have access to this profile?
        if ($profile->user_id != Auth::user()->id)
            abort(403, 'You do not have permission to edit this profile!');

        // Only validate unique entries should they have changed (prevents duplicate entry)
        if ($request->name != $profile->name)
        {
            $this->validateWith([
                'name' => ['required', 'string', 'min:1', 'max:16', 'alpha_dash', Rule::unique('profiles')->where(function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })]
            ]);
            $profile->name = $request->name;
        }

        if ($request->link != $profile->link)
        {
            $this->validateWith([
                'link' => 'required|string|min:3|max:32|alpha_dash|unique:profiles'
            ]);
            $profile->link = strtolower($request->link);
        }

        // These can be mass validated
        $this->validateWith([
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

        if ($request->displayName != $profile->display_name)
            $profile->display_name = $request->displayName;

        if ($request->motto != $profile->motto)
            $profile->motto = $request->motto;

        if ($dob != $profile->date_of_birth)
            $profile->date_of_birth = $dob;

        if ($request->location != $profile->location)
            $profile->location = $request->location;

        if ((is_null($request->country) ? null : strtoupper($request->country)) != $profile->country)
            $profile->country = (is_null($request->country) ? null : strtoupper($request->country));

        // Manipulate and save avatar.
        if (!is_null($request->avatar))
        {
            $img = Image::make($request->file('avatar'));
            $img->fit(512, 512, function($constraint) {
                $constraint->upsize();
            });

            if (is_null($img->save(storage_path('app/public/avatars/' . $profile->avatar . '.png'))))
            {
                LaraFlash::danger('An error occurred saving your profile image.');
                return redirect()->back()->withInput();
            }
        }

        if ($profile->save())
        {
            LaraFlash::success('Successfully updated your profile! (' . $profile->name . ')');
            return redirect(route('profile.show', $profile->link));
        }
        else
        {
            LaraFlash::danger('An error occurred while updating your profile.');
            return redirect()->back()->withInput();
        }
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

        if ($profile->user_id != Auth::user()->id)
            abort(403, 'You do not have permission to delete that profile!');

        $avatar = $profile->avatar;
        if ($profile->delete())
        {
            event(new ProfileDeleted($avatar));
            LaraFlash::success('The profile (' . $profileLink . ') has been destroyed.');
        }
        else
        {
            LaraFlash::danger('Something prevented us from destroying the profile!');
        }

        return redirect(route('profile.index'));
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
