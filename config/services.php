<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'twitter' => [
        'client_id' => env('TWITTER_KEY'),
        'client_secret' => env('TWITTER_SECRET'),
        'redirect' => env('TWITTER_REDIRECT_URI'),
    ],

    'youtube' => [
        'client_id' => env('YOUTUBE_KEY'),
        'client_secret' => env('YOUTUBE_SECRET'),
        'redirect' => env('YOUTUBE_REDIRECT_URI'),
    ],

    'battlenet' => [
        'client_id' => env('BATTLENET_KEY'),
        'client_secret' => env('BATTLENET_SECRET'),
        'redirect' => env('BATTLENET_REDIRECT_URI'),
    ],

    'vimeo' => [
        'client_id' => env('VIMEO_KEY'),
        'client_secret' => env('VIMEO_SECRET'),
        'redirect' => env('VIMEO_REDIRECT_URI'),
    ],

    'discord' => [
        'client_id' => env('DISCORD_KEY'),
        'client_secret' => env('DISCORD_SECRET'),
        'redirect' => env('DISCORD_REDIRECT_URI'),
    ],

    'reddit' => [
        'client_id' => env('REDDIT_KEY'),
        'client_secret' => env('REDDIT_SECRET'),
        'redirect' => env('REDDIT_REDIRECT_URI'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_KEY'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],

    'instagram' => [
        'client_id' => env('INSTAGRAM_KEY'),
        'client_secret' => env('INSTAGRAM_SECRET'),
        'redirect' => env('INSTAGRAM_REDIRECT_URI'),
    ],

    'imgur' => [
        'client_id' => env('IMGUR_KEY'),
        'client_secret' => env('IMGUR_SECRET'),
        'redirect' => env('IMGUR_REDIRECT_URI'),
    ],

    'linkedin' => [
        'client_id' => env('LINKEDIN_KEY'),
        'client_secret' => env('LINKEDIN_SECRET'),
        'redirect' => env('LINKEDIN_REDIRECT_URI'),
    ],

    'live' => [
        'client_id' => env('LIVE_KEY'),
        'client_secret' => env('LIVE_SECRET'),
        'redirect' => env('LIVE_REDIRECT_URI'),
    ],

    'steam' => [
        'client_id' => null,
        'client_secret' => env('STEAM_KEY'),
        'redirect' => env('STEAM_REDIRECT_URI'),
    ],

    'twitch' => [
        'client_id' => env('TWITCH_KEY'),
        'client_secret' => env('TWITCH_SECRET'),
        'redirect' => env('TWITCH_REDIRECT_URI'),
    ],

    'dribbble' => [
        'client_id' => env('DRIBBBLE_KEY'),
        'client_secret' => env('DRIBBBLE_SECRET'),
        'redirect' => env('DRIBBBLE_REDIRECT_URI'),
    ],

    'deviantart' => [
        'client_id' => env('DEVIANTART_KEY'),
        'client_secret' => env('DEVIANTART_SECRET'),
        'redirect' => env('DEVIANTART_REDIRECT_URI'),
    ],

    'tumblr' => [
        'client_id' => env('TUMBLR_KEY'),
        'client_secret' => env('TUMBLR_SECRET'),
        'redirect' => env('TUMBLR_REDIRECT_URI'),
    ],

    'flickr' => [
        'client_id' => env('FLICKR_KEY'),
        'client_secret' => env('FLICKR_SECRET'),
        'redirect' => env('FLICKR_REDIRECT_URI'),
    ],

    'medium' => [
        'client_id' => env('MEDIUM_KEY'),
        'client_secret' => env('MEDIUM_SECRET'),
        'redirect' => env('MEDIUM_REDIRECT_URI'),
    ],

    'mixer' => [
        'client_id' => env('MIXER_KEY'),
        'client_secret' => env('MIXER_SECRET'),
        'redirect' => env('MIXER_REDIRECT_URI'),
    ],

    'unsplash' => [
        'client_id' => env('UNSPLASH_KEY'),
        'client_secret' => env('UNSPLASH_SECRET'),
        'redirect' => env('UNSPLASH_REDIRECT_URI'),
    ],

    'etsy' => [
        'client_id' => env('ETSY_KEY'),
        'client_secret' => env('ETSY_SECRET'),
        'redirect' => env('ETSY_REDIRECT_URI'),
    ],

    'dailymotion' => [
        'client_id' => env('DAILYMOTION_KEY'),
        'client_secret' => env('DAILYMOTION_SECRET'),
        'redirect' => env('DAILYMOTION_REDIRECT_URI'),
    ],

    'patreon' => [
        'client_id' => env('PATREON_KEY'),
        'client_secret' => env('PATREON_SECRET'),
        'redirect' => env('PATREON_REDIRECT_URI'),
    ],

    'soundcloud' => [
        'client_id' => env('SOUNDCLOUD_KEY'),
        'client_secret' => env('SOUNDCLOUD_SECRET'),
        'redirect' => env('SOUNDCLOUD_REDIRECT_URI'),
    ],

    'spotify' => [
        'client_id' => env('SPOTIFY_KEY'),
        'client_secret' => env('SPOTIFY_SECRET'),
        'redirect' => env('SPOTIFY_REDIRECT_URI'),
    ],

    'stackexchange' => [
        'client_id' => env('STACKEXCHANGE_ID'),
        'client_secret' => env('STACKEXCHANGE_SECRET'),
        'redirect' => env('STACKEXCHANGE_REDIRECT_URI'),
        'key' => env('STACKEXCHANGE_KEY'),
        'site' => env('STACKEXCHANGE_SITE'),
    ],

    '500px' => [
        'client_id' => env('500PX_KEY'),
        'client_secret' => env('500PX_SECRET'),
        'redirect' => env('500PX_REDIRECT_URI'),
    ]

];
