<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class ProductFilter extends Component
{
    public $categories;

    public function render()
    {
        $this->categories = Category::all();
        return view('livewire.product-filter');
    }
}
