<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\Attributes\Url;


class Products extends Component
{
    public $products;

    #[Url]
    public $category = '';

    public function render()
    {
        $category = $this->category;
        if($category != null)
        {
            $categories = Category::where('slug', $category)->firstOrFail();
            $this->products = $categories->products()->get();
        }
        else
        {
            $this->products = Product::all();
        }
        return view('livewire.products')->title('Products');
    }
}
