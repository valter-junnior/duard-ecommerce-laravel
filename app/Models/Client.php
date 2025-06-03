<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'document',
        'phone_number',
        'postal_code',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
