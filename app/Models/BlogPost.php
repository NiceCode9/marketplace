<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $table = 'blog_posts';

    protected $fillable = ['title', 'slug', 'excerpt', 'content', 'cover_url', 'status', 'published_at'];

    protected $casts = ['published_at' => 'datetime'];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}