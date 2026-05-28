<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
   use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $guarded = [];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => PostStatus::class,
    ];

    // Relación con Categorías
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    // Relación con Etiquetas
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
