<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;

class NavigationMenuMain extends Component
{
  public $categories;

  public function render()
  {
    $this->categories = Category::whereNull('parent_id')->get();
    return view('livewire.navigation-menu-main');
  }

  public function addToCart(Request $request, $productId)
  {
    $cart = session()->get('cart', []);

    // Get the product
    $product = Product::find($productId);

    if(!$product) {
      return redirect()->back()->with('error', 'Product not found.');
    }

    // If product exists in cart, increment quantity
    if(isset($cart[$productId])) {
      $cart[$productId]['quantity']++;
    } else {
        // Add to cart
      $cart[$productId] = [
        "name" => $product->name,
        "quantity" => 1,
        "price" => $product->price_after_discount,
        "image" => $product->image
      ];
    }

    session()->put('cart', $cart);

    // return redirect()->back()->with('success', 'Product added to cart successfully!');
  }

  public function mergeCart()
  {
    $sessionCart = session()->get('cart', []);
    $user = auth()->user();

    foreach ($sessionCart as $productId => $details) {
      $cartItem = $user->cart()->where('product_id', $productId)->first();

      if ($cartItem) {
        $cartItem->quantity += $details['quantity'];
        $cartItem->save();
      } else {
        $user->cart()->create([
          'product_id' => $productId,
          'quantity' => $details['quantity']
        ]);
      }
    }

    session()->forget('cart');
  }


}
