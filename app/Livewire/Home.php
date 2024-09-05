<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Slides;
use App\Models\Category;
use App\Models\Product;

class Home extends Component
{
    public $slides;
    public $categories;
    public $products;

    public function render()
    {
        $this->slides = Slides::all();
        $this->categories = Category::whereNull('parent_id')->get();
        $this->products = Product::all();
        
        return view('livewire.home')->title('Home');
    }
}
