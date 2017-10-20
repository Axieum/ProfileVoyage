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
        'name', 'date_of_birth', 'location'
    ];

    /**
    * The profile's respective user.
    *
    * @return App\User
    */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
