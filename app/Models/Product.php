<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

   protected $fillable = [
        'name', 'description', 'price', 'quantity', 
        'image', 'status', 'company_id', 'sizes', 
        'colors', 'additional_images'
    ];

    protected $casts = [
        'sizes' => 'array',
        'colors' => 'array',
        'additional_images' => 'array'
    ];
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    // التحقق من توفر المنتج
    public function getIsAvailableAttribute()
    {
        return $this->status == 'active' && $this->quantity > 0;
    }

    public function getStatusTextAttribute()
    {
        return $this->status == 'active' ? 'Available' : 'Out of Stock';
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('images/products/' . $this->image);
        }
        return asset('images/placeholder.jpg');
    }
}