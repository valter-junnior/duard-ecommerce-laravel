<?php

namespace App\Traits;

trait HasMenuConfig
{
    protected static ?string $navigationGroup = null;
    protected static ?int $navigationSort = null;
    protected static ?string $navigationIcon = null;
    protected static function getMenuConfig(): array
    {
        $config = config('filament-menu');

        foreach ($config as $section) {
            // ignora entradas que não têm 'resources' (como 'dashboard', 'admin' etc.)
            if (!isset($section['resources']) || !is_array($section['resources'])) {
                continue;
            }

            foreach ($section['resources'] as $resource) {
                if (($resource['class'] ?? null) === static::class) {
                    return [
                        'group'    => $section['group'] ?? null,
                        'icon'     => $resource['icon'] ?? null,
                        'sort'     => $resource['sort'] ?? null,
                        'label'    => $resource['label'] ?? null,
                        'singular' => $resource['singular'] ?? null,
                        'plural'   => $resource['plural'] ?? null,
                    ];
                }
            }
        }

        return [];
    }

    public static function getNavigationGroup(): ?string
    {
        return static::getMenuConfig()['group'];
    }

    public static function getNavigationIcon(): ?string
    {
        return static::getMenuConfig()['icon'];
    }

    public static function getNavigationSort(): ?int
    {
        return static::getMenuConfig()['sort'];
    }

    public static function getNavigationLabel(): string
    {
        return static::getMenuConfig()['label'];
    }

    public static function getModelLabel(): string
    {
        return static::getMenuConfig()['singular'] ?? parent::getModelLabel();
    }

    public static function getPluralModelLabel(): string
    {
        return static::getMenuConfig()['plural'] ?? parent::getPluralModelLabel();
    }
}
