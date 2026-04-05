<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   protected $fillable = ['user_id', 'laptop_id', 'quantity', 'alamat', 'payment_method', 'status'];

public function user() {
    return $this->belongsTo(User::class);
}

public function laptop() {
    return $this->belongsTo(Laptop::class);
}
}