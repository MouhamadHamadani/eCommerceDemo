<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\CartItem;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class ProductDetails extends Component
{
  #[Url]
  public $slug = '';

  public $product;
  public $quantity = 1;
  public $totalPrice;

  // public function mount(Product $product)
  // {
  //     $this->product = $product;
  // }

  public function updated($propertyName)
  {
    if ($propertyName === 'quantity') {
      $this->calculateTotal();
    }
  }

  private function calculateTotal()
  {
    $discountedPrice = $this->product->discount_price ?? $this->product->price;
    $this->totalPrice = $this->quantity * $discountedPrice;
  }

  public function render()
  {
    $this->product = Product::where("slug", $this->slug)->first();
    $this->calculateTotal();

    if ($this->product == "")
      abort(404);

    return view('livewire.product-details')->title('Product Details');
  }

  public function addToCart($productId)
  {
    $user = Auth::user();
    $guestToken = request()->cookie('guest_token');

    if (!$user && !$guestToken) {
      $guestToken = Str::uuid()->toString();
      Cookie::queue('guest_token', $guestToken, 60 * 24 * 30); // Store for 30 days
    }

    // Find or create the cart for the user or guest
    $cart = Cart::firstOrCreate([
      'user_id' => $user ? $user->id : null,
      'guest_token' => $user ? null : $guestToken,
    ]);

    // Add item to cart (or update quantity)
    $cartItem = CartItem::updateOrCreate(
      ['cart_id' => $cart->id, 'product_id' => $productId],
      ['quantity' => $this->quantity]
    );

    // $this->loadCart();
    $this->dispatch("loadCart");
    session()->flash('message', 'Item added to cart!');
  }
}
