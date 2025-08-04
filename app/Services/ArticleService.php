<?php

namespace App\Services;

use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ArticleService
{
    private ArticleRepositoryInterface $articleRepository;

    public function __construct(ArticleRepositoryInterface $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getAllArticles(?string $title, $slugs)
    {
        return $this->articleRepository->getAllArticles($title, $slugs);
    }

    public function getDetailArticle(string $slug)
    {
        return $this->articleRepository->getDetailArticle($slug);
    }

    public function getArticleTags(string $slug)
    {
        return $this->articleRepository->getArticleTags($slug);
    }

    public function saveArticle(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['thumbnail']) && $data['thumbnail'] instanceof \Illuminate\Http\UploadedFile) {
                $path = $data['thumbnail']->store('articles', 'public');
                $data['thumbnail'] = $path;
            }

            // Panggil repository dan simpan data
            return $this->articleRepository->saveArticle([
                'title'         => $data['title'],
                'slug'          => $data['slug'],
                'summary'       => $data['summary'],
                'content'       => $data['content'],
                'thumbnail'     => $data['thumbnail'] ?? null,
                'is_published'  => $data['is_published'] ?? false,
                'published_at'  => $data['published_at'] ?? null,
                'created_by'    => $data['created_by'], 
            ]);
        });
    }


}