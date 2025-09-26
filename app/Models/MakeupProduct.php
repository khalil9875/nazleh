<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MakeupProduct extends Model
{
    use HasFactory;

    protected $table = 'makeup_product';

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'quantity',
        'status',
        'colors',
        'company_id',
        'categ'
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // العلاقة مع جدول companies
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // دالة للحصول على القيم الممكنة للتصنيف
    public static function getCategoryOptions()
    {
        return [
            'cosmatic' => 'Cosmatic',
            'skin care' => 'Skin Care',
            'makeup' => 'Makeup'
        ];
    }
}