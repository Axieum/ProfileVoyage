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
}
