<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'sku', 'price', 'quantity', 'description'];

    // Automatically generate SKU when a new product is created
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // Generate SKU using product name and random number
            $sku = strtoupper(substr($product->name, 0, 3)) . '-' . Str::random(6);
            
            // Ensure the SKU is unique
            while (Product::where('sku', $sku)->exists()) {
                $sku = strtoupper(substr($product->name, 0, 3)) . '-' . Str::random(6);
            }

            $product->sku = $sku;
        });
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_products');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function firstImage()
    {
        return $this->hasOne(ProductImage::class)->oldest(); // Get the first image
    }

    public function secondImage()
    {
        return $this->hasOne(ProductImage::class)
            ->whereNotIn('id', [$this->firstImage()?->id])
            ->orderBy('created_at')
            ->limit(1);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
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
                return number_format($this->price * (1 - $discount->discount_percentage / 100), 2);
            } elseif ($discount->discount_amount) {
                return number_format(max(0, $this->price - $discount->discount_amount), 2);
            }
        }

        return number_format($this->price, 2);
    }

    public function getDiscountAttribute()
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
                return $discount->discount_percentage . "%";
            } elseif ($discount->discount_amount) {
                return $discount->discount_amount . "$";
            }
        }

        return 0;
    }
}
