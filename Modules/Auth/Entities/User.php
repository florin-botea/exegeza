<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'image', 'description',
    ];
    
    public function getProfilePictureAttribute()
    {//dd($this->image, asset($this->image));
        return $this->image ? asset($this->image) : '/assets/default-user-image.png';
    }
}
