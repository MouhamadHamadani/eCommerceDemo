<div class="py-5 md:px-10 px-5">
    <h2 class="text-4xl font-bold">Shopping Cart</h2>

    @if(empty($cartItems))
        <p>Your cart is empty.</p>
    @else
        <div class="flex flex-col gap-2 mt-5 bg-white p-5 rounded-lg">
            @foreach($cartItems as $item)
                <div class="flex justify-between items-center border p-2">
                    <div class="flex items-center gap-2">
                    <img src="{{ Storage::url('products/' . $item->product->firstImage->image) }}" class="md:w-24 md:h-24 h-12 w-12 object-cover">
                    <span>{{ $item->product->name }}</span>
                    @foreach ($product->categories as $key => $category)
                      <a href="{{ route('products', ['category' => $category->slug]) }}"
                        class="text-green-700 hover:text-green-500">{{ $category->name }}</a>{{ count($product->categories) - 1 > $key ? ',' : '' }}
                    @endforeach
                    </div>
                    <input type="number" wire:model.lazy="cartItems.{{ $loop->index }}.quantity"
                           wire:change="updateQuantity({{ $item->id }}, $event.target.value)" class="w-16 text-center">
                    <button wire:click="removeFromCart({{ $item->id }})" class="text-red-500">Remove</button>
                </div>
            @endforeach
        </div>

        <p class="text-right font-bold">Total: ${{ number_format($this->getTotal(), 2) }}</p>
        <button class="mt-3 p-2 bg-green-500 text-white">Proceed to Checkout</button>
    @endif
</div>
