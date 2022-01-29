<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewLog extends Model
{
    protected $fillable = ['article_id', 'slug', 'url', 'session_id', 'user_id', 'ip_address', 'user_agent'];
}
