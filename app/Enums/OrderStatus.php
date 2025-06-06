<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING    = 'pending';
    case PAID       = 'paid';
    case CANCELED   = 'canceled';
    case SHIPPED    = 'shipped';
    case DELIVERED  = 'delivered';
    case RETURNED   = 'returned';

    public function label(): string
    {
        return match($this) {
            self::PENDING    => 'Pendente',
            self::PAID       => 'Pago',
            self::CANCELED   => 'Cancelado',
            self::SHIPPED    => 'Enviado',
            self::DELIVERED  => 'Entregue',
            self::RETURNED   => 'Devolvido',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
