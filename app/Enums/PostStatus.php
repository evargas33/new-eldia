<?php

namespace App\Enums;

enum PostStatus: string
{
    case DRAFT = 'draft';
    case REVIEW = 'review';
    case PUBLISHED = 'published';

    // Una función auxiliar para ponerle etiquetas bonitas en español
    public function getLabel(): string
    {
        return match($this) {
            self::DRAFT => 'Borrador 📝',
            self::REVIEW => 'En Revisión ⏳',
            self::PUBLISHED => 'Publicado 🚀',
        };
    }
}