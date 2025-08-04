<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\ArticleService;
use App\Services\TagsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
    private ArticleService $articleService;
    private TagsService $tagsService;

    public function __construct(ArticleService $articleService, TagsService $tagsService)
    {
        $this->articleService = $articleService;
        $this->tagsService = $tagsService;
    }

    public function index(User $user)
    {
        return Inertia::render("Articles/Index", $this->articleService->getArticlesByUser($user->id));
    }

    public function create() 
    {
        $tags = $this->tagsService->getAllTags();

        return Inertia::render("Articles/Create", [
            'tags' => $tags
        ]);
    }

    public function store(Request $request)
    {
        $this->articleService->saveArticle($request->all());

        return redirect(route('dashboard'));
    }
}
