<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Article\StoreArticleRequest;
use App\Http\Requests\Admin\Article\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('admin/Article', [
            'data' => Article::withTrashed()->paginate($request->integer('perPage', 10)),
        ]);
    }

    public function store(StoreArticleRequest $request): RedirectResponse
    {
        Article::create($request->validated());

        return back();
    }

    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        $article->update($request->validated());

        return back();
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return back();
    }
}
