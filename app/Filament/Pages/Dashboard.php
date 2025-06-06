<?php

namespace App\Filament\Pages;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

    public $stats;

    public function mount()
    {
        $this->stats = [
            'orders' => Order::count(),
            'clients' => Client::count(),
            'products' => Product::count(),
            'revenue' => Order::where('status', 'paid')->sum('total_amount'),
        ];
    }
}
