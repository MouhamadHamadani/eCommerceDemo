<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getPriceAfterDiscountAttribute()
    {
        $discount = $this->discounts()
        ->where(function ($query) {
            $query->whereNull('start_date')->orWhere('start_date', '<=', now());
        })
        ->where(function ($query) {
            $query->whereNull('end_date')->orWhere('end_date', '>=', now());
        })
        ->orderByDesc('discount_percentage')
        ->orderByDesc('discount_amount')
        ->first();

        if ($discount) {
            if ($discount->discount_percentage) {
                return $this->price * (1 - $discount->discount_percentage / 100);
            } elseif ($discount->discount_amount) {
                return max(0, $this->price - $discount->discount_amount);
            }
        }

        return $this->price;
    }
}
