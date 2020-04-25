<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\MustVerifyEmail as MV;
use Illuminate\Support\Str;
use App\Notifications\SubscriptionNotification;

class Subscribe extends Model implements MustVerifyEmail
{
    use Notifiable;
    use MV;

    protected $fillable = ['email'];

    public function sendEmailVerificationNotification()
    {
        //$this->token = Str::random(40);
        //$this->save;

        $this->notify(new SubscriptionNotification());
    }
}
