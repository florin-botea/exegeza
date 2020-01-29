<?php

namespace App\Traits;

use Illuminate\Support\Arr;

/**
 * dependinte: table model_has_tags si tags
 */

trait HasTags
{
    public function addTags(array $tags)
    {
        \App\ModelHasTag::where(["model_type" => get_class($this), "model_id" => $this->id])->delete();

        foreach ($tags as $tag) {
            $value = is_array($tag) ? $tag['value'] : $tag;
            $this->addTag($value);
        }
    }

    public function addTag(string $tag)
    {
        $tag = \App\Tag::firstOrCreate([
            "value" => $tag,
            "language_id" => $this->language->id
        ]);
        \App\ModelHasTag::create([
            "model_type" => get_class($this),
            "model_id" => $this->id,
            "tag_id" => $tag->id,
            'user_id' => 1
        ]);
    }

    public function tags()
    {
        return $this->hasManyThrough(\App\Tag::class, \App\ModelHasTag::class, 'model_id', 'id', 'id', 'tag_id')->where('model_type', get_class($this));
    }
}