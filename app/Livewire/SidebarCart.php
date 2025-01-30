<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class SidebarCart extends Component
{
    public $cartItems = [];
    public $quantities = [];
    public $totalPrice = 0;
    public $user;
    public $guestToken;
    // public $isOpen = false;

    public function mount()
    {
        $this->user = Auth::user();
        $this->guestToken = session()->get('guest_token');

        $this->loadCartItems();
    }

    public function render()
    {
        return view('livewire.sidebar-cart');
    }

    #[On('loadCart')]
    public function loadCartItems()
    {
        $cart = Cart::where('user_id', $this->user?->id)
            ->orWhere('guest_token', $this->guestToken)
            ->with(['cartItems.product' => function ($query) {
                $query->with(['firstImage']); // Load the first image
            }])
            ->first();


        //   $this->cartItems = $cart ? $cart->cartItems->toArray() : [];

        $this->cartItems = $cart ? $cart->cartItems : [];
        
        $this->totalPrice = 0; // Reset before recalculating
        // Initialize quantity array
        foreach ($this->cartItems as $item) {
            $this->quantities[$item->id] = $item->quantity;
            $this->totalPrice += $item->product->price * $item->quantity;
        }

        //   dd($this->cartItems[0]->product->firstImage->image);
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        if ($quantity < 1) return;

        $cartItem = CartItem::find($cartItemId);
        if ($cartItem) {
            $cartItem->update(['quantity' => $quantity]);
        }

        $this->loadCartItems();
    }

    public function removeFromCart($cartItemId)
    {
        CartItem::destroy($cartItemId);
        $this->loadCartItems();
    }
}
