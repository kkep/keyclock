<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use PharIo\Manifest\Author;

class Comment extends Model
{
    use SoftDeletes;

    protected $guarded = null;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
