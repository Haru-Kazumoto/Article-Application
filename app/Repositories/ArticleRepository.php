<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ArticleRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function getAllArticles(?string $title, $slugs)
    {
        if (is_string($slugs)) {
            $slugs = explode(',', $slugs); // amanin kalau dikirim via slugs=foo,bar
        }

        // force default empty array kalau null
        $slugs = is_array($slugs) ? $slugs : [];

        $query = DB::table('articles as art')
            ->join('article_tags as at', 'at.article_id', '=', 'art.id')
            ->leftJoin('tags as t', 't.id', '=', 'at.tag_id')
            ->leftJoin('users as u','u.id','=','art.created_by')
            ->select(
                'art.id as article_id',
                'art.title',
                'art.slug',
                'art.summary',
                'art.thumbnail',
                'art.published_at',
                't.name as tag_name',
                'u.fullname as publisher_name'
            );

        if (!empty($title)) {
            $query->where('art.title', 'like', "%$title%");
        }

        if (!empty($slugs)) {
            $query->where(function ($q) use ($slugs) {
                foreach ($slugs as $word) {
                    $q->orWhere('t.slug', 'like', "%{$word}%"); //filter berdasarkan slug tag
                }
            });
        }

        $articles = $query->latest('art.published_at')->paginate(20);

        // konpersi thumbnail menjadi asset URL
        $articles->getCollection()->transform(function ($data) {
            $data->thumbnail = $data->thumbnail ? asset($data->thumbnail) : null;
            $data->published_at = \Carbon\Carbon::parse($data->published_at)->diffForHumans();
            return $data;
        });

        return $articles;

    }

    public function getDetailArticle(string $slug)
    {
        return DB::table('articles as art')
            ->join('users as u', 'u.id', '=', 'art.created_by')
            ->select([
                'art.id as article_id',
                'art.title',
                'art.slug',
                'art.summary',
                'art.thumbnail',
                'art.content',
                'art.published_at',
                'u.fullname',
                'u.join_at',
            ])
            ->where('art.slug', $slug)
            ->first(); 
    }

    public function getArticleTags(string $slug)
    {
        return DB::table("tags as t")
            ->join('article_tags as at','at.tag_id','=','t.id')
            ->join('articles as art','at.article_id','=','art.id')
            ->select('t.name')
            ->where('art.slug','=',$slug)
            ->get();
    }

    public function saveArticle(array $data)
    {
        return DB::table('articles')->insert($data);
    }
}