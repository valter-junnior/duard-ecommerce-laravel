<?php

use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\ClientResource;

return [
    'dashboard' => [
        'label' => 'Dashboard',
        'icon' => 'heroicon-o-home',
        'class' => \App\Filament\Pages\Dashboard::class,
        'sort' => -10, // aparecer no topo
    ],

    'sales' => [
        'group' => 'Vendas',
        'resources' => [
            [
                'class'    => OrderResource::class,
                'icon'     => 'heroicon-o-shopping-cart',
                'sort'     => 10,
                'label'    => 'Pedidos',
                'singular' => 'Pedido',
                'plural'   => 'Pedidos',
            ],
        ],
    ],

    'ecommerce' => [
        'group' => 'E-commerce',
        'resources' => [
            [
                'class'    => CategoryResource::class,
                'icon'     => 'heroicon-o-rectangle-group',
                'sort'     => 10,
                'label'    => 'Categorias',
                'singular' => 'Categoria',
                'plural'   => 'Categorias',
            ],
            [
                'class'    => ProductResource::class,
                'icon'     => 'heroicon-o-cube',
                'sort'     => 20,
                'label'    => 'Produtos',
                'singular' => 'Produto',
                'plural'   => 'Produtos',
            ],
        ],
    ],

    'clients' => [
        'group' => 'Clientes',
        'resources' => [
            [
                'class'    => ClientResource::class,
                'icon'     => 'heroicon-o-users',
                'sort'     => 10,
                'label'    => 'Clientes',
                'singular' => 'Cliente',
                'plural'   => 'Clientes',
            ],
        ],
    ],
];
