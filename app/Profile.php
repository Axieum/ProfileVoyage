<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'link', 'name', 'display_name', 'motto', 'date_of_birth', 'location', 'country', 'active'
    ];

    /**
     * Retrieve the user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Retrieve its country
     */
    public function countryObject()
    {
        return $this->belongsTo('App\Country', 'country', 'code');
    }

    /**
     * Retrieve its socials
     */
    public function socials()
    {
        return $this->belongsToMany('App\Social')->withTimestamps();
    }
}
