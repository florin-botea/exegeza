<?php

namespace App\Traits;

trait HasLanguage
{
    public function setLanguage(string $language)
    {
        $language = \App\Language::firstOrCreate(["value" => $language]);
        \App\ModelHasLanguage::firstOrCreate([
            "model_type" => get_class($this),
            "model_id" => $this->id,
            "language_id" => $language->id
        ]);
    }

    public function language()
    {
        return $this->hasOneThrough(\App\Language::class, \App\ModelHasLanguage::class, 'model_id', 'id', 'id', 'language_id')->where('model_type', get_class($this));
    }
}