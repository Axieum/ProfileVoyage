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
        'name', 'display_name', 'motto', 'avatar', 'date_of_birth', 'location', 'country', 'active'
    ];

    /**
     * Retrieve the user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
