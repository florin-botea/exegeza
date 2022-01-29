<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verse extends Model
{
    protected $fillable = [
        'bible_version_id',
        'book_id',
        'chapter_id',
        'book_index',
        'chapter_index',
        'index',
        'text',
    ];

    public function book()
    {
        return $this->hasOne(\App\Book::class, 'id', 'book_id');
    }

    public function bible()
    {
        return $this->hasOne(\App\BibleVersion::class, 'id', 'bible_version_id');
    }
}
