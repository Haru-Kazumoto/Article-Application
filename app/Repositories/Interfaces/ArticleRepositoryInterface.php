<?php

namespace App\Repositories\Interfaces;

interface ArticleRepositoryInterface
{
    public function getAllArticles(?string $title, $slugs);
    public function getDetailArticle(string $slug);
    public function getArticleTags(string $slug);
    public function getArticlesByUser(int $user_id);
    public function saveArticle(array $data);
}