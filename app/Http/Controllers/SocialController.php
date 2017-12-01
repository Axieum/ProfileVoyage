<?php

namespace App\Http\Controllers;

use App\Social;
use App\SocialPlatform;
use Auth;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Http\Request;
use LaraFlash;
use Socialite;

class SocialController extends Controller
{
    /**
     * Resource constructor
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socials = Auth::user()->socials()->select('*', 'socials.id as id')->join('social_platforms', 'social_platforms.id', '=', 'socials.platform_id')->orderBy('social_platforms.display_name')->get();
        $platforms = SocialPlatform::all()->sortBy('display_name');
        return view('link.index')->withSocials($socials)->withPlatforms($platforms);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $social = Social::where('id', $id)->first();

        if (is_null($social))
            abort(404, 'Unfortunately, there is nothing here.');

        if ($social->user_id != Auth::user()->id)
            abort(403, 'You do not have permission to do that.');

        $profiles = $social->profiles;

        return view('link.show')->withSocial($social)->withProfiles($profiles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function request(Request $request)
    {
        // Check if the platform is supported - database query.
        if (!SocialPlatform::where('name', $request->platform)->exists())
        {
            LaraFlash::danger('Unsupported platform! (' . $request->platform . ')');
            return redirect()->back();
        }

        // Send the OAuth request for the desired platform.
        return Socialite::with($request->platform)->redirect();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function callback($platform)
    {
        // Check if the platform is supported - database query.
        $platformObject = SocialPlatform::where('name', $platform)->first();
        if (is_null($platformObject))
            abort(404, 'Unsupported platform! (' . $platform . ')');

        // Retrieve the entity.
        $entity = Socialite::driver($platformObject->name)->user();

        // Link entity to the user.
        $social = new Social;
        $social->user_id = Auth::user()->id;
        $social->platform_id = $platformObject->id;

        // Handle the stored value (UUID, Username, etc.)
        $socialValue = null;
        $socialUrl = null;
        switch ($platformObject->name)
        {
            case 'twitter':
                $socialValue = '@' . $entity->nickname;
                $socialUrl = 'https://twitter.com/' . $entity->nickname;
                break;
            case 'youtube':
                $socialValue = $entity->user['snippet']['title'];
                $socialUrl = 'https://youtube.com/channel/' . $entity->user['id'];
                break;
            case 'battlenet':
                $socialValue = $entity->accessTokenResponseBody['battletag'];
                $socialUrl = 'https://battle.net';
                break;
            case 'vimeo':
                $socialValue = $entity->accessTokenResponseBody['user']['name'];
                $socialUrl = $entity->accessTokenResponseBody['user']['link'];
                break;
            case 'discord':
                $socialValue = $entity->nickname;
                $socialUrl = 'https://discordapp.com';
                break;
            case 'reddit':
                $socialValue = 'u/' . $entity->nickname;
                $socialUrl = 'https://reddit.com/user/' . $entity->nickname;
                break;
            case 'google':
                $socialValue = $entity->user['displayName'];
                $socialUrl = 'https://' . $entity->user['url'];
                break;
            case 'instagram':
                $socialValue = null;
                $socialUrl = '';
                break;
            case 'imgur':
                $socialValue = $entity->accessTokenResponseBody['account_username'];
                $socialUrl = 'https://imgur.com/user/' . $entity->accessTokenResponseBody['account_username'];
                break;
            case 'linkedin':
                $socialValue = $entity->name;
                $socialUrl = $entity->user['publicProfileUrl'];
                break;
            case 'live':
                $socialValue = null;
                $socialUrl = '';
                break;
            case 'steam':
                $socialValue = $entity->nickname;
                $socialUrl = $entity->user['profileurl'];
                break;
            case 'twitch':
                $socialValue = $entity->user['display_name'];
                $socialUrl = 'https://twitch.tv/' . $entity->user['name'];
                break;
            case 'dribbble':
                $socialValue = $entity->user['name'];
                $socialUrl = $entity->user['html_url'];
                break;
            case 'deviantart':
                $socialValue = $entity->user['username'];
                $socialUrl = 'https://' . $entity->user['username'] . '.deviantart.com';
                break;
            case 'tumblr':
                $socialValue = $entity->nickname;
                $socialUrl = 'https://www.tumblr.com/search/' . $entity->nickname;
                break;
            case 'flickr':
                $socialValue = $entity->nickname;
                $socialUrl = $entity->user['profileurl']['_content'];
                break;
            case 'medium':
                $socialValue = $entity->name;
                $socialUrl = $entity->user['data']['url'];
                break;
            case 'mixer':
                $socialValue = $entity->username;
                $socialUrl = 'https://mixer.com/' . $entity->username;
                break;
            case 'unsplash':
                $socialValue = $entity->user['username'];
                $socialUrl = $entity->profileUrl;
                break;
            case 'etsy':
                $socialValue = $entity->nickname;
                $socialUrl = 'https://etsy.com/people/' . $entity->nickname;
                break;
            case 'dailymotion':
                $socialValue = $entity->user['screenname'];
                $socialUrl = 'https://dailymotion.com/' . $entity->user['username'];
                break;
            case 'patreon':
                $socialValue = $entity->name;
                $socialUrl = $entity->user['data']['attributes']['url'];
                break;
            // case 'soundcloud':
            //     $socialValue = null;
            //     $socialUrl = '';
            //     break;
            case 'spotify':
                $socialValue = $entity->user['id'];
                $socialUrl = $entity->user['external_urls']['spotify'];
                break;
            case 'stackexchange':
                if (!isset($entity->user['items'][0]))
                {
                    LaraFlash::warning('A Stack Overflow account was not found! Try again later.');
                    return redirect(route('link.index'));
                }
                $socialValue = $entity->user['items'][0]['display_name'];
                $socialUrl = $entity->user['items'][0]['link'];
                break;
            case '500px':
                $socialValue = $entity->name;
                $socialUrl = 'https://500px.com/' . $entity->nickname;
                break;
            default:
                $socialValue = isset($entity->name) ? $entity->name : null;
                $socialUrl = url(route('index'));
                break;
        }
        $social->value = $socialValue;
        $social->url = $socialUrl;

        // Check if duplicate entry (would prefer a composite unique in the database).
        if(Social::where('user_id', Auth::user()->id)->where('platform_id', $platformObject->id)->where('value', $socialValue)->exists())
        {
            LaraFlash::warning('You\'ve already linked that ' . $platformObject->display_name . ' account!');
            return redirect(route('link.index'));
        }

        // Return
        if (!(is_null($socialValue) || is_null($socialUrl)) && $social->save())
            LaraFlash::success('Successfully linked a new ' . $platformObject->display_name . ' account!');
        else
            LaraFlash::danger('Something prevented us from linking the ' . $platformObject->display_name . ' account!');

        return redirect(route('link.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unlink($id)
    {
        $social = Social::where('id', $id)->first();
        $social_platform = $social->platform->display_name;

        if (is_null($social))
            abort(404, 'A social link with the id ' . $id . " couldn't be found.");

        if ($social->user_id != Auth::user()->id)
            abort(403, 'You do not have permission to delete that profile!');

        if ($social->delete())
        {
            LaraFlash::success('The social account (' . $social_platform . ') has been unlinked.');
        }
        else
        {
            LaraFlash::danger('Something prevented us from unlinking the account!');
        }

        return redirect(route('link.index'));
    }
}
