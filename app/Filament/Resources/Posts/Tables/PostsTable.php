<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Enums\PostStatus;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                // 1. La miniatura del banner bien pulida y con imagen por defecto
                ImageColumn::make('image_banner')
                    ->label('Portada')
                    // Usamos una función anónima: si hay datos en la DB, que use la imagen; si es null, que use el placeholder directo
                    ->state(fn($record) => $record->image_banner ? $record->image_banner : null)
                    ->defaultImageUrl(asset('images/placeholder.jpg'))
                    ->circular()
                    ->imagesize(50),

                // 2. El Título: Le damos todo el peso visual
                TextColumn::make('title')
                    ->label('Título de la Nota')
                    ->searchable()
                    ->sortable()
                    ->wrap() // Si el título es largo, baja de renglón en vez de empujar la pantalla
                    ->weight('bold'),
                TextColumn::make('categories.name')
                    ->label('Categoría')
                    ->sortable()
                    ->badge() // Se ve muy limpio como una pequeña insignia gris
                    ->color('gray'),

                // 3. El Estado Editorial: Lo convertimos en una insignia (Badge) con color
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge() // ⬅️ Convierte el texto en un botón/insignia de color
                    // En Filament v4 mapeamos los colores directo al valor de tu Enum o texto:
                    ->color(fn(PostStatus $state): string => match ($state) {
                        PostStatus::PUBLISHED => 'success', // Verde
                        PostStatus::DRAFT => 'warning',     // Amarillo/Naranja
                        PostStatus::SCHEDULED => 'info',    // Azul
                        default => 'gray',
                    })
                    ->sortable(),

                // 4. Fecha de publicación: Limpia y bien formateada
                TextColumn::make('published_at')
                    ->label('Publicación')
                    ->dateTime('d M, Y H:i') // Ej: 27 May, 2026 14:30
                    ->sortable()
                    ->toggleable(), // Permite al usuario ocultarla o mostrarla si quiere

                // 5. Columnas secundarias: Las dejamos ocultas por defecto para eliminar el scroll horizontal
                TextColumn::make('slug')
                    ->label('URL')
                    ->toggleable(isToggledHiddenByDefault: true), // El usuario puede activarla desde el botón de columnas

                TextColumn::make('subtitle')
                    ->label('Subtítulo')
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                // Aquí irán tus filtros después
                SelectFilter::make('categories')
                    ->label('Filtrar por Categoría')
                    ->relationship('categories', 'name')
                    ->preload()
                    ->multiple(), // Permite filtrar por varias categorías a la vez si se requiere
            ]);
    }
}
