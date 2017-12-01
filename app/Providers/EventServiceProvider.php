<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserRegistered' => [
            'App\Listeners\SendWelcomeEmail'
        ],
        'App\Events\UserUpdated' => [
            'App\Listeners\SendVerityEmail'
        ],
        'App\Events\ProfileDeleted' => [
            'App\Listeners\DeleteAvatar'
        ],
        'SocialiteProviders\Manager\SocialiteWasCalled' => [
            'SocialiteProviders\Twitter\TwitterExtendSocialite@handle',
            'SocialiteProviders\YouTube\YouTubeExtendSocialite@handle',
            'SocialiteProviders\Battlenet\BattlenetExtendSocialite@handle',
            'SocialiteProviders\Vimeo\VimeoExtendSocialite@handle',
            'SocialiteProviders\Discord\DiscordExtendSocialite@handle',
            'SocialiteProviders\Reddit\RedditExtendSocialite@handle',
            'SocialiteProviders\Google\GoogleExtendSocialite@handle',
            'SocialiteProviders\Instagram\InstagramExtendSocialite@handle',
            'SocialiteProviders\Imgur\ImgurExtendSocialite@handle',
            'SocialiteProviders\LinkedIn\LinkedInExtendSocialite@handle',
            'SocialiteProviders\Live\LiveExtendSocialite@handle',
            'SocialiteProviders\Steam\SteamExtendSocialite@handle',
            'SocialiteProviders\Twitch\TwitchExtendSocialite@handle',
            'SocialiteProviders\Dribbble\DribbbleExtendSocialite@handle',
            'SocialiteProviders\Deviantart\DeviantartExtendSocialite@handle',
            'SocialiteProviders\Tumblr\TumblrExtendSocialite@handle',
            'SocialiteProviders\Flickr\FlickrExtendSocialite@handle',
            'SocialiteProviders\Medium\MediumExtendSocialite@handle',
            'SocialiteProviders\Mixer\MixerExtendSocialite@handle',
            'SocialiteProviders\Unsplash\UnsplashExtendSocialite@handle',
            'SocialiteProviders\Etsy\EtsyExtendSocialite@handle',
            'SocialiteProviders\Dailymotion\DailymotionExtendSocialite@handle',
            'SocialiteProviders\Patreon\PatreonExtendSocialite@handle',
            'SocialiteProviders\SoundCloud\SoundCloudExtendSocialite@handle',
            'SocialiteProviders\Spotify\SpotifyExtendSocialite@handle',
            'SocialiteProviders\StackExchange\StackExchangeExtendSocialite@handle',
            'SocialiteProviders\FiveHundredPixel\FiveHundredPixelExtendSocialite@handle'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
