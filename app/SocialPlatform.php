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
            'snapchat' => 'snapchat-ghost',
            'facebook' => 'facebook-square'
        );
        return isset($translations[$this->name]) ? $translations[$this->name] : $this->name;
    }
}
