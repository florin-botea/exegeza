<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'parent',
        'content',
        'user_id'
    ];

    protected $hidden = [
        'model_type', 'model_id',
    ];

    public function author()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function toJqueryComment()
    {
        $comment = $this->toArray();
        $comment = array_merge($comment, [
            'author' => $this->author->name,
            'profile_picture_url' => $this->author->getPhotoUrl(),
            'profile_url' => route('users.show', $this->author->id),
        ]);

        return $comment;
    }
}
