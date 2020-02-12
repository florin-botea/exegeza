<?php

namespace App\Observers;

use App\Article;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use PHPHtmlParser\Dom;

class ArticleObserver
{
    public function created(Article $article)
    {
        //$dom = new Dom;
        //$dom->load($article->content);
        //dd($dom->find('img'));
    }

    public function updated(Article $article)
    {
        //$dom = new Dom;
        //$dom->load($article->content);
        //dd($dom->find('img'));
    }

/*
    public function created(Article $article)
    {
        $tags = request()->tags;
        $language = request()->lang;
        $this->updateArticleTags($article, $tags);
        if ($language) {
            $this->updateArticleLanguage($article, $language);
        }    
    }

    public function updated(Article $article)
    {
        $tags = request()->tags;
        $language = request()->lang;
        $this->updateArticleTags($article, $tags);
        if ($language) {
            $this->updateArticleLanguage($article, $language);
        }
    }

    public function deleted(Article $article)
    {
        //
    }

    public function restored(Article $article)
    {
        //
    }

    public function forceDeleted(Article $article)
    {
        //
    }

    private function updateArticleTags(Article $article, $tags)
    {
        $tags = json_decode($tags, true);
        if (!$tags) {
            return;
        }
        $tags = array_map(function($tag){ return $tag['value']; }, $tags);
        $insertionsIds = [];
        foreach ($tags as $tag) {
            $tag = \App\Tag::firstOrCreate(['value' => $tag]);
            $article->tagsRelationship()->firstOrCreate([
                'model_type' => get_class($article),
                'tag_id' => $tag->id
            ], ['user_id' => 1]);
            $insertionsIds[] = $tag->id;
        }
        $article->tagsRelationship()->whereNotIn('tag_id', $insertionsIds)->delete();
    }

    private function updateArticleLanguage(Article $article, $language)
    {
        $language = \App\Language::firstOrCreate(['language' => $language]);
        $article->langRelationship()->updateOrCreate([
            'model_type' => get_class($article),
        ], ['language_id' => $language->id]);
    }*/
}
