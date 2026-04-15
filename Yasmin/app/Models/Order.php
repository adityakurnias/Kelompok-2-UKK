<?php
// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'buyer_id', 'total_price', 'shipping_address',
        'payment_method', 'payment_proof', 'status'
    ];

    // Accessor untuk URL Bukti Pembayaran
    public function getPaymentProofUrlAttribute(): string
    {
        if (empty($this->payment_proof)) {
            return 'https://placehold.co/600x800?text=No+Proof';
        }

        if (Storage::disk('public')->exists('payments/' . $this->payment_proof)) {
            return asset('storage/payments/' . $this->payment_proof);
        }

        return 'https://placehold.co/600x800?text=Proof+Not+Found';
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}