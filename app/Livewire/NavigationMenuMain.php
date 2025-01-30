<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class NavigationMenuMain extends Component
{
  public $categories;
  public $cartItems = [];

  protected $listeners = ['mergeCart'];

  public function render()
  {
    $this->categories = Category::whereNull('parent_id')->get();
    return view('livewire.navigation-menu-main');
  }

  // public function mergeCart()
  // {
  //   $sessionCart = session()->get('cart', []);
  //   $user = auth()->user();

  //   foreach ($sessionCart as $productId => $details) {
  //     $cartItem = $user->cart()->where('product_id', $productId)->first();

  //     if ($cartItem) {
  //       $cartItem->quantity += $details['quantity'];
  //       $cartItem->save();
  //     } else {
  //       $user->cart()->create([
  //         'product_id' => $productId,
  //         'quantity' => $details['quantity']
  //       ]);
  //     }
  //   }

  //   session()->forget('cart');
  // }



}
