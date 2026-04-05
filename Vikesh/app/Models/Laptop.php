<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    protected $fillable = [
        'model', 
        'processor', 
        'ram', 
        'storage', 
        'price', 
        'description', 
        'image'
    ];
}