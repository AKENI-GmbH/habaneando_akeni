<?php

namespace App\Providers\Filament;

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Session\Middleware\StartSession;
use Akaunting\Language\Middleware\SetLocale;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use App\Filament\Widgets\DashboardOverview;
use App\Filament\Widgets\DashboardTable;
use Filament\Http\Middleware\Authenticate;
use Filament\Support\Colors\Color;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\PanelProvider;
use Filament\Pages;
use Filament\Widgets;
use Filament\Panel;

use Filament\Tables\Columns\Column;


class AdminPanelProvider extends PanelProvider
{

    public function panel(Panel $panel): Panel
    {

        Column::configureUsing(function (Column $column): void {
            $column
                ->toggleable()
                ->translateLabel()
                ->searchable()
                ->sortable();
        });

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->sidebarCollapsibleOnDesktop()
            ->login()
            ->profile()
            ->userMenuItems([
                'logout' => MenuItem::make()->label('Log out'),
            ])
            ->colors([
                'primary' => Color::Amber,
                'danger' => Color::Rose,
                'gray' => Color::Gray,
                'info' => Color::Blue,
                'success' => Color::Emerald,
                'warning' => Color::Orange,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                // Pages\Dashboard::class,
                \App\Filament\Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                DashboardOverview::class,
            ])
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make())
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
                SetLocale::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])->navigationGroups([
                NavigationGroup::make()
                    ->label('Habaneando')
                    ->icon('heroicon-o-musical-note')
                    ->collapsed(true),

                NavigationGroup::make()
                    ->label(__('Pricing'))
                    ->icon('heroicon-o-currency-euro')
                    ->collapsed(false),


                NavigationGroup::make()
                    ->label(__('Settings'))
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(false),
            ]);
    }
}
