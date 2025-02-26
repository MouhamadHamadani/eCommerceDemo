<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartPage extends Component
{
    public $cartItems = [];
    
    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $user = Auth::user();
        $guestToken = session()->get('guest_token');

        $cart = Cart::where('user_id', $user?->id)
        ->orWhere('guest_token', $guestToken)
        ->with(['cartItems.product' => function ($query) {
            $query->with(['firstImage']); // Load the first image
        }])
        ->first();
        
        $this->cartItems = $cart ? $cart->cartItems : [];
    }

    public function updateQuantity($itemId, $quantity)
    {
        $item = CartItem::find($itemId);
        if ($item) {
            $item->update(['quantity' => $quantity]);
            $this->loadCart();
        }
    }

    public function removeFromCart($itemId)
    {
        CartItem::destroy($itemId);
        $this->loadCart();
    }

    public function getTotal()
    {
        return collect($this->cartItems)->sum(fn($item) => $item['product']['price'] * $item['quantity']);
    }

    public function render()
    {
        return view('livewire.cart-page')->title('Cart');
    }
}
