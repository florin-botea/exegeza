<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
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
        return $this->hasOne(UserDetails::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
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

    public function deletionRequest()
    {
        return $this->hasOne(DeletionRequest::class)->where('model_type', get_class($this));
    }

    public function assignBasicRolesAndPermissions()
    {
        if ($this->id === 1) {
            $this->assignRole('developer');
            $this->assignRole('admin');
        }
        $this->assignRole('user');
    }

    public function makeDeletionRequest($days)
    {
        return DeletionRequest::updateOrCreate([
            'model_type' => get_class($this),
            'model_id' => $this->id
        ], [
            'deadline' => Carbon::now()->addDays($days)->timestamp,
            'user_id' => auth()->user()->id
        ]);
    }

    public function abortDeletion()
    {
        return DeletionRequest::where([
            'model_type' => get_class($this),
            'model_id' => $this->id
        ])->delete();
    }
}
