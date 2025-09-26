<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo'
    ];

    // العلاقة مع جدول المنتجات
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // دالة للحصول على صورة الشركة
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('images/companies/' . $this->logo);
        }
        return asset('images/placeholder.jpg');
    }
}