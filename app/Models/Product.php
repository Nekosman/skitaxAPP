<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'image', 'stock', 'price', 'barcode'];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function sales()
    {
        return $this->belongsToMany(Sale::class)
                    ->withPivot('quantity', 'price', 'discount')
                    ->withTimestamps();
    }
}
