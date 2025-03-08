<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Like\StoreLikeRequest;
use App\Http\Requests\Admin\Like\UpdateLikeRequest;
use App\Models\Like;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LikeController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('admin/Like', [
            'data' => Like::withTrashed()->paginate($request->integer('perPage', 10)),
        ]);
    }

    public function store(StoreLikeRequest $request): RedirectResponse
    {
        Like::create($request->validated());

        return back();
    }

    public function update(UpdateLikeRequest $request, Like $like): RedirectResponse
    {
        $like->update($request->validated());

        return back();
    }

    public function destroy(Like $like): RedirectResponse
    {
        $like->delete();

        return back();
    }
}
