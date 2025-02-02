<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TopDiscountedProducts extends Component
{
    use WithPagination;

    public function render()
    {
        $today = Carbon::now(); // Get the current date

        $products = Product::select(
            'products.*',
            'discounts.end_date as discount_end_date',
            'discounts.discount_percentage',
            'discounts.discount_amount'
        )
            ->leftJoin('discount_products', 'products.id', '=', 'discount_products.product_id')
            ->leftJoin('discounts', function ($join) use ($today) {
                $join->on('discount_products.discount_id', '=', 'discounts.id')
                    ->where('discounts.start_date', '<=', $today)
                    ->where('discounts.end_date', '>=', $today);
            })
            ->where("products.quantity", ">", 0)
            ->whereNotNull('discounts.id') // Ensures only products with active discounts are retrieved
            ->orderByRaw("
            CASE 
                WHEN discounts.discount_percentage IS NOT NULL THEN (products.price * discounts.discount_percentage / 100)
                WHEN discounts.discount_amount IS NOT NULL THEN discounts.discount_amount
                ELSE 0 
            END DESC
        ")
            ->paginate(10);

        return view('livewire.top-discounted-products', compact('products'));
    }
}
