<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name'
    ];

    /**
     * Retrieve all associated profiles
     */
    public function profiles()
    {
        return $this->hasMany('App\Profile', 'country', 'code');
    }
}
