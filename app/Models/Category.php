<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function products()
    {
        return $this->hasMany(Products::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class);
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function getPriceAfterDiscountAttribute(Product $product)
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
                return $product->price * (1 - $discount->discount_percentage / 100);
            } elseif ($discount->discount_amount) {
                return max(0, $product->price - $discount->discount_amount);
            }
        }

        return $product->price;
    }

}
