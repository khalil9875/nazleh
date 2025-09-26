<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];

    protected $casts = [
        'quantity' => 'integer'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getSubtotal()
    {
        return $this->product->price * $this->quantity;
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['product'] = $this->product ? $this->product->toArray() : null;
        $array['subtotal'] = $this->getSubtotal();
        return $array;
    }
}
