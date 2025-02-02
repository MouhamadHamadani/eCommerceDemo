<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Carbon\Carbon;

class NewProducts extends Component
{
    public $products;

    public function render()
    {
        $this->products = Product::where('created_at', '>=', Carbon::now()->subWeek())->inRandomOrder()
            ->limit(5)
            ->get();
        return view('livewire.new-products');
    }
}
