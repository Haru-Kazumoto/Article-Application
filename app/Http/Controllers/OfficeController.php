<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use App\Services\TagsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OfficeController extends Controller
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
        $articles = $this->articleService->getAllArticles(null, null);

        return Inertia::render("Articles/Index", [
            'articles' => $articles
        ]);
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

        return redirect(route('office'))->with('success','Berhasil membuat data!');
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}
