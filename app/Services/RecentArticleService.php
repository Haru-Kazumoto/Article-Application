<?php

namespace App\Services;

use App\Repositories\Interfaces\RecentArticleRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecentArticleService
{
    private RecentArticleRepositoryInterface $recentArticleRepository;

    public function __construct(RecentArticleRepositoryInterface $recentArticleRepository)
    {
        $this->recentArticleRepository = $recentArticleRepository;
    }

    public function getRecents()
    {
        return $this->recentArticleRepository->getRecents(Auth::user()->id);
    }

    public function storeIfNotExist($article_id)
    {
        return DB::transaction(function() use ($article_id) {
            return $this->recentArticleRepository->storeIfNotExist($article_id);
        });
    }
}