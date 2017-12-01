<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialPlatform extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name'
    ];

    /**
     * Retrieve all socials of this type
     */
    public function entities()
    {
        return $this->hasMany('App\Social');
    }

    /**
     * Translate platform for font-awesome icon
     */
    public function icon()
    {
        $translations = array(
            'youtube' => 'youtube-play',
            'snapchat' => 'snapchat',
            'facebook' => 'facebook-box',
            'battlenet' => 'gamepad-variant',
            'vimeo' => 'vimeo',
            'discord' => 'discord',
            'reddit' => 'reddit',
            'google' => 'google-plus',
            'instagram' => 'instagram',
            'imgur' => 'image-filter-center-focus',
            'linkedin' => 'linkedin-box',
            'live' => 'xbox',
            'steam' => 'steam',
            'twitch' => 'twitch',
            'dribbble' => 'dribbble-box',
            'deviantart' => 'deviantart',
            'tumblr' => 'tumblr',
            'flickr' => 'checkbox-multiple-blank-circle',
            'medium' => 'medium',
            'mixer' => 'mixer',
            'unsplash' => 'camera',
            'etsy' => 'etsy',
            'dailymotion' => 'weather-sunny',
            'patreon' => 'wallet',
            'soundcloud' => 'soundcloud',
            'spotify' => 'spotify',
            'stackexchange' => 'stackoverflow',
            '500px' => 'image'
        );
        return isset($translations[$this->name]) ? $translations[$this->name] : $this->name;
    }
}
