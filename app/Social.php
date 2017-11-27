<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'platform_id', 'value'
    ];

    /**
     * Retrieve the platform type
     */
    public function platform()
    {
        return $this->belongsTo('App\SocialPlatform', 'platform_id');
    }

    /**
     * Retrieve the owner
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Retrieve assigned profiles
     */
    public function profiles()
    {
        return $this->belongsToMany('App\Profile')->withTimestamps();;
    }
}
