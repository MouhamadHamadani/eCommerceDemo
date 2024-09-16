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
    #[Url(except: '')]
    public $category = '';

    // Filter
    #[Url(except: null)]
    public $price_min;
    #[Url(except: null)]
    public $price_max;

    public $name = 'shop';
    public $image_name = 'shop';

    public $query = '';

    protected $listeners = ['filterUpdated'];
 
    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        if($this->category != '')
        {
            $slug = explode(",", $this->category);
        }

        // Check if the category exists and load products accordingly
        if (isset($slug)&& $slug != null) {
            $categories = Category::whereIn('slug', $slug)->get();

            if(count($categories) == 1)
            {
                $this->name = $categories->first()->name;
                $this->image_name = $this->name;
            }
            else
            {
                $this->name = '';
                foreach ($categories as $key => $categoryName)
                {
                    $this->name .= $categoryName->name . (count($categories) - 1  > $key ? ", " : "");
                }
            }

            $categoryModel = Category::whereIn('slug', $slug)->pluck('id')->toArray();
            $products = Product::whereHas('categories', function ($query) use ($categoryModel) {
                $query->whereIn('categories.id', $categoryModel);
            });
        } else {
            $products = new Product();
        }

        if($this->price_min != null)
        {
            $products = $products->where("price", ">=" , $this->price_min);
        }


        if($this->price_max != null)
        {
            $products = $products->where("price", "<=" , $this->price_max);
        }

        $products = $products->paginate(10);

        // Render the view and set the page title
        return view('livewire.products', ["products" => $products])->title('Products');
    }

    public function filterUpdated($selectedCategories, $price_min, $price_max)
    {
        if(count($selectedCategories))
        {
            $this->category = '';
            for ($i=0; $i < count($selectedCategories) - 1; $i++)
            { 
                $this->category .= $selectedCategories[$i] . ',';
            }
            $this->category .= $selectedCategories[count($selectedCategories) - 1];

            if(count($selectedCategories)> 1)
            {
                $this->image_name = 'shop';
            }
        }
        else
        {
            $this->name = 'shop';
            $this->image_name = 'shop';
            $this->category = '';
        }

        $this->price_min = $price_min;
        $this->price_max = $price_max;
    }
}
