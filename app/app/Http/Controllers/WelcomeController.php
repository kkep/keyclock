<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Welcome', [
            'articles' => Article::paginate(),
        ]);
    }
}
