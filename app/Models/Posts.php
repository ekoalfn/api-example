<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Posts extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'news_content', 'author', 'image'
    ];

    public function Writer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

    public function Comment(): HasMany
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
}
