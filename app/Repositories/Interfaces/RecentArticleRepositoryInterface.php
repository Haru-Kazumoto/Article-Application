<?php

namespace App\Repositories\Interfaces;

interface RecentArticleRepositoryInterface
{
    public function storeIfNotExist(int $article_id);
    public function getRecents(int $user_id);
}