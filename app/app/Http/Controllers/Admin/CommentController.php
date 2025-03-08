<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Comment\StoreCommentRequest;
use App\Http\Requests\Admin\Comment\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CommentController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('admin/Comment', [
            'data' => Comment::withTrashed()->paginate($request->integer('perPage', 10)),
        ]);
    }

    public function store(StoreCommentRequest $request): RedirectResponse
    {
        Comment::create($request->validated());

        return back();
    }

    public function update(UpdateCommentRequest $request, Comment $comment): RedirectResponse
    {
        $comment->update($request->validated());

        return back();
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return back();
    }
}
