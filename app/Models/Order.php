<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'shipping_address_id',
        'status',
        'total_amount',
    ];

    protected $casts = [
        'status' => \App\Enums\OrderStatus::class,
    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /*public function payment()
    {
        return $this->hasOne(Payment::class);
    }*/
}
