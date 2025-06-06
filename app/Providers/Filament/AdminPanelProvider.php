<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
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

use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
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
            ])
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                $config = config('filament-menu');

                // Itens soltos fora de grupos
                $ungroupedItems = [];

                if (isset($config['dashboard'])) {
                    $page = $config['dashboard'];
                    $class = $page['class'];

                    $ungroupedItems[] = NavigationItem::make($page['label'] ?? 'Dashboard')
                        ->url(fn() => $class::getUrl())
                        ->icon($page['icon'] ?? 'heroicon-o-home')
                        ->sort($page['sort'] ?? 0);
                }

                // Grupos com recursos
                $groups = collect($config)
                    ->filter(fn($val, $key) => $key !== 'dashboard') // ignora item solto
                    ->map(function ($section) {
                        $items = collect($section['resources'] ?? [])
                            ->filter(fn($resource) => class_exists($resource['class'] ?? ''))
                            ->map(function ($resource) {
                                $class = $resource['class'];

                                return NavigationItem::make($resource['label'] ?? class_basename($class))
                                    ->url(fn() => $class::getUrl('index'))
                                    ->icon($resource['icon'] ?? 'heroicon-o-document')
                                    ->sort($resource['sort'] ?? 0);
                            })
                            ->sortBy(fn($item) => $item->getSort())
                            ->values()
                            ->all();

                        return NavigationGroup::make($section['group'] ?? 'Outros')
                            ->icon($section['icon'] ?? null)
                            ->items($items);
                    });

                return $builder
                    ->items($ungroupedItems)
                    ->groups($groups->all());
            })
            ->databaseTransactions();
    }
}
