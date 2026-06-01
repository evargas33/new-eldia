<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;



class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')

            ->login()
            // 1. 🎨 CONFIGURACIÓN DE COLORES DEL DÍA
            ->colors([
                // Cambiamos el color primario al azul oficial de tu logo (usa tu código HEX real)
                'primary' => Color::rgb('rgb(0, 102, 204)'), // O puedes usar HEX directo: '#0066cc'
                'gray' => Color::Zinc, // Un gris elegante para los fondos y textos secundarios
            ])

            // 2. 🖼️ PERSONALIZACIÓN VISUAL (LOGO Y BRANDING)
            ->brandName('El Día de Michoacán') // Nombre en la pestaña si no carga el logo
            ->brandLogo(asset('images/placeholder.jpg')) // 👈 Pon aquí la ruta real de tu logo limpio de "El Día" si tienes uno horizontal
            ->brandLogoHeight('2.5rem') // Controla el tamaño para que no se desfase el menú
            ->favicon(asset('images/favicon.png')) // El ícono chiquito de la pestaña del navegador

            // 3. 🛡️ EXTRAS DE IDENTIDAD
            ->sidebarCollapsibleOnDesktop() // Hace que el menú izquierdo se pueda encoger para dar más espacio
          
            
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
