<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;

use App\Filament\Helper\CustomLogin;

class ShopManagerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('shop-manager')
            ->path('shop-manager')
            ->login(CustomLogin::class)
            ->registration()
            ->profile()
            ->colors([
                'primary' => Color::Amber,
            ])
            // Created by DK START
            ->brandName('Welcome, ' . auth()->user()?->name)
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Welcome, ' . auth()->user()?->name)
            ])
            ->maxContentWidth('full')
            // ->topNavigation()
            ->font('Poppins')
            // ->favicon(fn () => view('filament.faviconlogo'))
            ->favicon(url('website/assets/logo/stor1.jpg'))
            ->brandLogo(fn () => view('filament.storLogo')) // Dashboard sidebar logo
            // ->brandName('Go Bong Stor')
            ->sidebarCollapsibleOnDesktop()
            // ->databaseNotifications()
            // ->databaseNotificationsPolling('30s')
            // Created by DK END

            ->discoverResources(in: app_path('Filament/ShopManager/Resources'), for: 'App\\Filament\\ShopManager\\Resources')
            ->discoverPages(in: app_path('Filament/ShopManager/Pages'), for: 'App\\Filament\\ShopManager\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/ShopManager/Widgets'), for: 'App\\Filament\\ShopManager\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
