<?php
// app/Models/Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'name', 'description',
        'price', 'condition', 'status', 'image'
    ];

    // ── ACCESSOR: otomatis fallback ke default jika file tidak ada ──
    public function getImageUrlAttribute(): string
    {
        // Jika gambar adalah URL eksternal (Unsplash, dll)
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        // Jika gambar ada di storage lokal
        if ($this->image && Storage::disk('public')->exists('products/' . $this->image)) {
            return asset('storage/products/' . $this->image);
        }

        // Fallback default
        return asset('images/default-product.jpg');
    }

    // ── RELATIONS ──
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}