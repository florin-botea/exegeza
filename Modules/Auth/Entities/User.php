<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Auth\Database\factories\UserFactory::new();
    }
    
    public function getProfilePictureAttribute()
    {
        return $this->image ? asset($this->image) : '/assets/default-user-image.png';
    }
}
