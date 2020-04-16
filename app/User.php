<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function details() 
    {
        return $this->hasOne(\App\UserDetails::class);
    }

    public function articles() 
    {
        return $this->hasMany(\App\Article::class);
    }

    public function getBio()
    {
        return $this->details ? $this->details->bio : '';
    }

    public function getDescription()
    {
        return $this->details && $this->details->description ? $this->details->description->content : '';
    }

    public function getPhotoUrl()
    {
        return $this->details && $this->details->photo ? asset($this->details->photo) : '/assets/default-user-image.png';
    }
}
