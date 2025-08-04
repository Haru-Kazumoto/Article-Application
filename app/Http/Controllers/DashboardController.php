<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Services\RecentArticleService;
use App\Services\TagsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    private ArticleService $articleService;
    private TagsService $tagsService;

    public function __construct(ArticleService $articleService, TagsService $tagsService)
    {
        $this->articleService = $articleService;
        $this->tagsService = $tagsService;
    }

    public function index(Request $request) 
    {
        $title = $request->input('title');
        $slugs = $request->input('slugs', []); 

        $articles = $this->articleService->getAllArticles($title, $slugs);
        $tags = $this->tagsService->getAllTags();

        return Inertia::render("Dashboard", [
            'articles' => $articles,
            'tags' => $tags,
            'recents' => app(RecentArticleService::class)->getRecents(),
            'filters' => [
                'title' => $title,
                'slugs' => $slugs,
            ]
        ]);
    }

    public function detail(Request $request)
    {
        $article = $this->articleService->getDetailArticle($request->slug);
        $article_tags = $this->articleService->getArticleTags($request->slug);

        return Inertia::render("Articles/Detail", [
            'article' => $article,
            'tags' => $article_tags
        ]);
    }

}
