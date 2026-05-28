<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('slug'),
                TextEntry::make('subtitle')
                    ->placeholder('-'),
                TextEntry::make('content')
                    ->columnSpanFull()
                    ->html()
                    ->columnSpanFull(),
                ImageEntry::make('image_banner')
                    ->placeholder('-')
                    ->label('Imagen de Portada')
                    // ⬇️ EN FILAMENT V4 SE USA ASÍ (Alto en píxeles, Ancho en píxeles o string) ⬇️
                    ->imageHeight('45rem')

                    // Nos aseguramos de que la imagen se adapte sin deformarse
                    ->extraImgAttributes([
                        'style' => 'object-fit: cover; border-radius: 0.5rem; width: 100%;',
                    ])
                    ->columnSpan(2), // Le damos 2 columnas para que la leyenda (caption) tenga su propio lado,
                TextEntry::make('image_caption')
                    ->placeholder('-')
                    ->label('Leyenda de la Imagen')
                    ->placeholder('Sin descripción')
                    ->columnSpan(1),
                TextEntry::make('views_count')
                    ->numeric(),
                TextEntry::make('seo_title')
                    ->placeholder('-'),
                TextEntry::make('seo_description')
                    ->placeholder('-'),
                TextEntry::make('status'),
                TextEntry::make('published_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
