<?php 

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UserRole: string implements HasLabel, HasColor
{
            case ADMIN = 'admin';
            case EDITOR = 'editor';
            case WRRITER = 'writer';
            
        

        public function getLabel(): ?string
        {
            return match ($this) {
                self::ADMIN => 'Administrador',
                self::EDITOR => 'Editor',
                self::WRRITER => 'Redactor / Escritor',
            };
        }

        public function getColor(): string|array|null
        {
            return match ($this) {
                self::ADMIN => 'danger',
                self::EDITOR => 'info',
                self::WRRITER => 'success',
            };
        }
}