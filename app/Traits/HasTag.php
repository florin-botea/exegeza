namespace App/Traits;

/**
    dependinte: table model_has_tags si tags
 */

trait HasLanguage
{
    public function addTags(array $tags)
    {
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }
    }

    public function addTag(string $tag)
    {
        $tag = \App\Tag::firstOrCreate([
            "value" => $tag,
            "language" => $this->language
        ]);
        \App\ModelHasTag::firstOrCreate([
            "model_type" => get_class($this),
            "model_id" => $this->id,
            "tag_id" => $tag->id
        ]);
    }

    public function tags()
    {
        return $this->hasManyThrough(\App\Tag::class, \App\ModelHasTag::class, 'model_id', 'id', 'id', 'tag_id')->where('model_type', get_class($this));
    }
}