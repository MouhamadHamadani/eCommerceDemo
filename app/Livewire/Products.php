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

    // sorting
    public $sorting = null;

    protected $listeners = ['filterUpdated'];
 
    public function search()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = $this->getProducts();
        // Render the view and set the page title
        return view('livewire.products', ["products" => $products])->title('Products');
    }

    public function getProducts()
    {
        if($this->category != '')
        {
            $slug = explode(",", $this->category);
        }

        $products = Product::select('products.*');

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
            $products = $products->whereHas('categories', function ($query) use ($categoryModel) {
                $query->whereIn('categories.id', $categoryModel);
            });
        }

        /*if($this->price_min != null)
        {
            $products = $products->where("price", ">=" , $this->price_min);
        }


        if($this->price_max != null)
        {
            $products = $products->where("price", "<=" , $this->price_max);
        }*/
        // dd($this->price_max);
        $minPrice = $this->price_min != 0 ? $this->price_min : 0;
        $maxPrice = $this->price_max != 0 ? $this->price_max : 10000;

        $products = $products->leftJoin('discount_products', 'products.id', '=', 'discount_products.product_id')
        ->leftJoin('discounts', 'discount_products.discount_id', '=', 'discounts.id')
        ->whereRaw('(products.price - (products.price * IFNULL(discounts.discount_percentage, 0) / 100)) BETWEEN ? AND ?', [$minPrice, $maxPrice]);

        if ($this->sorting != null && $this->sorting != "all") {
            $sorting = [
                "price_low" => ["col" => "price", "value" => "ASC"],
                "price_high" => ["col" => "price", "value" => "DESC"],
                "a_z" => ["col" => "name", "value" => "ASC"],
                "z_a" => ["col" => "name", "value" => "DESC"],
            ];
            $products = $products->orderBy($sorting[$this->sorting]["col"], $sorting[$this->sorting]["value"]);
        }

        $products = $products->paginate(10);

        return $products;
    }

    public function changeSorting() {}

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

        $this->price_min = $price_min != "" ? $price_min : null;
        $this->price_max = $price_max != "" ? $price_max : null;
    }
}
