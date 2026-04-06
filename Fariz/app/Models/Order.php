<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_price', 'address', 'status'];

    // Hubungan ke user yang beli
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Hubungan ke item-item yang dibeli
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}