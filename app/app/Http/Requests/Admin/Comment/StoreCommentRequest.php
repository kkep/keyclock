<?php

namespace App\Http\Requests\Admin\Comment;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'article_id' => ['required', 'integer', Rule::exists(Article::class, 'id')],
            'author_id' => ['required', 'integer', Rule::exists(User::class, 'id')],
            'text' => ['required'],
        ];
    }
}
