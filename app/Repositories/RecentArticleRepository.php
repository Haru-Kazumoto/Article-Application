<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RecentArticleRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RecentArticleRepository implements RecentArticleRepositoryInterface
{
    public function storeIfNotExist(int $article_id)
    {
        $article = DB::table("articles")->select('id')->where('id',$article_id)->first();
        $alreadyExists = DB::table("recent_articles")
            ->where('article_id', $article->id)
            ->exists();

        if (!$alreadyExists) {
            DB::table("recent_articles")->insert([
                'open_at' => now(),
                'user_id' => Auth::id(),
                'article_id' => $article->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function getRecents(int $user_id)
    {
        return DB::table('recent_articles as ra')
            ->join('articles as a', 'a.id', '=', 'ra.article_id')
            ->where('ra.user_id', $user_id)
            ->select([
                'a.id',
                'a.title',
                'a.slug',
            ])
            ->latest('ra.created_at')
            ->take(10)
            ->get();

    }
}