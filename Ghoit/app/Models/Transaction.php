<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'total_price',
        'shipping_name',
        'shipping_phone',
        'shipping_email',
        'shipping_address',
        'payment_method',
        'payment_proof',
        'refund_status',
        'refund_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
