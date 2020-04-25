<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogImages;

class UserDescription extends Model
{
    use LogImages;

    private $logImages = ['content'];

    protected $fillable = ['content'];
}
