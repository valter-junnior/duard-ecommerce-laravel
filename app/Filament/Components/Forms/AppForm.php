<?php

namespace App\Filament\Components\Forms;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;

class AppForm
{
    public static function make(array $main, ?array $offset = null, int $mainSpan = 2, int $offsetSpan = 1, int $columns = 3): Grid
    {
        $schema = [
            Group::make($main)->columnSpan($mainSpan),
        ];

        if (!empty($offset)) {
            $schema[] = Group::make($offset)->columnSpan($offsetSpan);
        }

        return Grid::make($columns)->schema($schema);
    }
}
