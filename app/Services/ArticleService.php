<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Str;

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
        $result_data = $this->articleRepository->getDetailArticle($slug);

        if(Auth::check()) {
            app(RecentArticleService::class)->storeIfNotExist($result_data->article_id);
        }

        return $result_data;
    }

    public function getArticleTags(string $slug)
    {
        return $this->articleRepository->getArticleTags($slug);
    }

    public function saveArticle(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Upload thumbnail
            if (isset($data['thumbnail']) && $data['thumbnail'] instanceof \Illuminate\Http\UploadedFile) {
                // simpan ke public/thumbnails
                $path = $data['thumbnail']->store('thumbnails', 'public');
                $data['thumbnail'] = $path;
            }

            // Simpan ke tabel articles
            $articleId = $this->articleRepository->saveArticle([
                'title'         => $data['title'],
                'slug'          => \Illuminate\Support\Str::slug($data['title']),
                'summary'       => $data['summary'],
                'content'       => $data['content'],
                'thumbnail'     => $data['thumbnail'] ?? null,
                'is_published'  => $data['is_published'] ?? false,
                'published_at'  => $data['published_at'] ?? null,
                'created_by'    => Auth::id(),
                'created_at'    => now(),
                'updated_at'    => now()
            ]);

            // Tangkap slug tags dari JSON string
            $tagSlugs = is_string($data['tags']) ? json_decode($data['tags'], true) : [];

            // Ambil tag_id berdasarkan slug
            $tagIds = DB::table('tags')
                ->whereIn('slug', $tagSlugs)
                ->pluck('id')
                ->toArray();

            // Simpan ke pivot table
            $pivotData = array_map(fn($tagId) => [
                'article_id' => $articleId,
                'tag_id' => $tagId,
            ], $tagIds);

            DB::table('article_tags')->insert($pivotData);

            return $articleId;
        });
    }


    public function getArticlesByUser(int $user_id)
    {
        $articles = $this->articleRepository->getArticlesByUser($user_id);
        $user = User::findOrFail($user_id);

        return [
            'articles' => $articles,
            'creator' => $user
        ];
    }

}