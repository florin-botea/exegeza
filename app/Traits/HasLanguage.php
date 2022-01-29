<?php

namespace App\Traits;

trait HasLanguage
{
    public function setLanguage(string $language)
    {
        $language = Language::firstOrCreate(["value" => $language]);
        ModelHasLanguage::firstOrCreate([
            "model_type" => get_class($this),
            "model_id" => $this->id,
            "language_id" => $language->id
        ]);
    }

    public function language()
    {
        return $this->hasOneThrough(Language::class, ModelHasLanguage::class, 'model_id', 'id', 'id', 'language_id')->where('model_type', get_class($this));
    }
}
