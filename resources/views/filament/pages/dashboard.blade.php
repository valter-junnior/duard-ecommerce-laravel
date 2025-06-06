<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-filament::widgets.stats-overview-widget.card
            heading="Pedidos"
            value="{{ $stats['orders'] }}"
            icon="heroicon-o-shopping-cart"
        />
        <x-filament::widgets.stats-overview-widget.card
            heading="Clientes"
            value="{{ $stats['clients'] }}"
            icon="heroicon-o-users"
        />
        <x-filament::widgets.stats-overview-widget.card
            heading="Produtos"
            value="{{ $stats['products'] }}"
            icon="heroicon-o-cube"
        />
        <x-filament::widgets.stats-overview-widget.card
            heading="Receita"
            value="R$ {{ number_format($stats['revenue'], 2, ',', '.') }}"
            icon="heroicon-o-currency-dollar"
        />
    </div>
</x-filament-panels::page>
