<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    protected $fillable = ['bio'];

    public function description() {
        return $this->hasOne(\App\UserDescription::class);
    }
}
