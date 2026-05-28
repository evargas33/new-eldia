<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group; // ⬅️ ¡ESTA ES LA RUTA CORRECTA EN LA V4!
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Enums\PostStatus;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                
                // Tu Grid de 3 columnas usando los Groups bien importados
                Grid::make(3)
                    ->schema([
                        
                        // Columna Izquierda (Contenido) -> Toma 2 columnas del Grid
                        Group::make([
                            Section::make('Contenido de la Nota')
                                ->schema([
                                    TextInput::make('title')
                                        ->label('Título de la Nota')
                                        ->required()
                                        ->maxLength(255)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                                    TextInput::make('slug')
                                        ->label('URL Amigable (Slug)')
                                        ->disabled()
                                        ->dehydrated()
                                        ->required()
                                        ->unique(Post::class, 'slug', ignoreRecord: true),

                                    RichEditor::make('content')
                                        ->label('Cuerpo de la noticia')
                                        ->required()
                                        ->columnSpanFull(),

                                    Select::make('categories')
                                        ->label('Categorías')
                                        ->relationship('categories', 'name')
                                        ->preload()
                                        ->searchable()
                                        ->multiple()
                                        ->required(),

                                    Select::make('tags')
                                        ->label('Etiquetas (Tags)')
                                        ->relationship('tags', 'name')
                                        ->preload()
                                        ->searchable()
                                        ->multiple(),
                                ]),
                        ])->columnSpan(2),

                        // Columna Derecha (Publicación) -> Toma 1 columna del Grid
                        Group::make([
                            Section::make('Publicación y Multimedia')
                                ->schema([
                                    Select::make('status')
                                        ->label('Estado Editorial')
                                        ->options(PostStatus::class)
                                        ->default(PostStatus::DRAFT)
                                        ->required()
                                        ->native(false),

                                    DateTimePicker::make('published_at')
                                        ->label('Fecha de Publicación')
                                        ->native(false)
                                        ->displayFormat('d/m/Y H:i'),

                                    FileUpload::make('image_banner')
                                        ->label('Imagen de Portada')
                                        ->image()
                                        ->directory('noticias')
                                        ->imageEditor()
                                        ->required(),
                                ]),
                        ])->columnSpan(1),
                        
                    ]),
            ])->columns(1); // El Grid principal ocupa 1 columna para que los Groups internos manejen su propio span
    }
}