<?php

namespace App\Observers;

use App\UserDescription;
use PHPHtmlParser\Dom;

class UserDescriptionObserver
{
    public function updated(UserDescription $description) {
        $this->updateDescriptionPhotosLog($description);
    }

    private function updateDescriptionPhotosLog(UserDescription $description) {
        $dom = new Dom;
        $dom->load($description->content);
        // delete old records for clear update
        \App\ModelHasPhoto::where(['model_type' => get_class($description), 'model_id' => $description->id])->delete();
        $stack = [];
        foreach($dom->find('img') as $img) {
            $stack[] = [
                'model_type' => get_class($description),
                'model_id' => $description->id,
                'photo' => $img->getAttribute('src')
            ];
        }

        \App\ModelHasPhoto::insert($stack);
    }
}
