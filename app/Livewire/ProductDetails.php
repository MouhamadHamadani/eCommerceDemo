<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Models\Product;

class ProductDetails extends Component
{
  #[Url]
  public $slug = '';

  public $product;

  public function render()
  {
    $this->product = Product::where("slug", $this->slug)->first();

    if($this->product == "")
      abort(404);

    return view('livewire.product-details')->title('Product Details');
  }
}
