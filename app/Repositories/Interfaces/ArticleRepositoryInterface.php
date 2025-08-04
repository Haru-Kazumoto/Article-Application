<?php

namespace App\Repositories\Interfaces;

interface ArticleRepositoryInterface
{
    public function getAllArticles(?string $title, $slugs);
    public function getDetailArticle(string $slug);
    public function getArticleTags(string $slug);
    public function saveArticle(array $data);
}