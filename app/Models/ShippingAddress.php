<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingAddress extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'postal_code',
        'address',
        'number',
        'complement',
        'district',
        'city',
        'state',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
