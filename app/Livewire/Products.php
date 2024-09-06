<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Product;
use App\Models\Category;

class Products extends Component
{
    use WithPagination;

    // public $products;
    #[Url]
    public $category = '';

    public $query = '';
 
    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $category = $this->category;

        // Check if the category exists and load products accordingly
        if ($category != null) {
            $categoryModel = Category::where('slug', $category)->firstOrFail();
            $products = $categoryModel->products()->paginate(10);
        } else {
            $products = Product::paginate(10);
        }

        // Render the view and set the page title
        return view('livewire.products', ["products" => $products])->title('Products');
    }
}
