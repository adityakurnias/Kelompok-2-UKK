<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Tambahkan 'id' di sini supaya bisa kita isi manual (ID 1)
    protected $fillable = [
        'id', 
        'name', 
        'slug'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}