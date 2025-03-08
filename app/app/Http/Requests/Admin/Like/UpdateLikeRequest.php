<?php

namespace App\Http\Requests\Admin\Like;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLikeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'article_id' => ['required', 'integer', Rule::exists(Article::class, 'id')],
            'user_id' => ['required', 'integer', Rule::exists(User::class, 'id')],
        ];
    }
}
