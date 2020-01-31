<?php

namespace App\Policies;

use App\User;
use App\Article;

class ArticlePolicy
{
    public function create(User $user)
    {
        return $user->hasAnyPermission('create articles');
    }

    public function update(User $user, Article $article)
    {
        return $user->hasAnyPermission('update articles') || $article->user_id === $user->id;
    }

    public function delete(User $user, Article $article)
    {
        return $user->hasAnyPermission('delete articles') || $article->user_id === $user->id;
    }

    public function publish(User $user, Article $article = null)
    {
        return $user->hasAnyPermission('publish articles');
    }

    public function unpublish(User $user, Article $article = null)
    {
        return $user->hasAnyPermission('unpublish articles');
    }
}