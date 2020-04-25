<?php

namespace App\Traits;

use PHPHtmlParser\Dom;
use App\ModelHasPhoto;
use Illuminate\Database\Eloquent\Model;

trait LogImages
{
    public static function bootLogImages()
    {
        static::created(function (Model $model) {
            $model->logImages();
        });

        static::updated(function (Model $model) {
            $model->logImages();
        });
    }

    private function logImages()
    {
        if (empty($this->logImages))
        return;

        $htmlContent = '';
        foreach ($this->logImages as $content) {
            $htmlContent .= $this[$content];
        }

        $dom = new Dom;
        $dom->load($htmlContent);
        // delete old records for clear update
        ModelHasPhoto::where(['model_type' => get_class($this), 'model_id' => $this->id])->delete();
        $stack = [];
        foreach($dom->find('img') as $img) {
            $stack[] = [
                'model_type' => get_class($this),
                'model_id' => $this->id,
                'photo' => $img->getAttribute('src')
            ];
        }
        ModelHasPhoto::insert($stack);
    }
}