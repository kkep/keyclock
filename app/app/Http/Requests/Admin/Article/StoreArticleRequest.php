<?php

namespace App\Http\Requests\Admin\Article;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'poster_url' => ['required', 'max:500', 'url'],
            'author_id' => ['required', 'integer', Rule::exists(User::class, 'id')],
            'text' => ['required'],
        ];
    }
}
