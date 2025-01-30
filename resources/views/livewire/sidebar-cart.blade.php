<div x-data="{ isOpen: false }">
  <div class="fixed inset-y-0 right-0 z-50">
    <!-- Overlay -->
    <div x-show="isOpen" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-200"
      x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
      class="fixed inset-0 bg-black bg-opacity-50" @click="isOpen = false"></div>

    <!-- Sidebar Cart -->
    <div x-show="isOpen" x-transition:enter="transition-transform ease-out duration-300"
      x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
      x-transition:leave="transition-transform ease-in duration-200" x-transition:leave-start="translate-x-0"
      x-transition:leave-end="translate-x-full" class="fixed inset-y-0 right-0 w-96 bg-white shadow-lg overflow-y-auto">
      <div class="p-6">
        <div class="flex justify-between items-center mb-6">
          <h2 class="text-xl font-semibold">Your Cart</h2>
          <button @click="isOpen = false" class="text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-xmark w-6 h-6"></i>
          </button>
        </div>

        <div class="space-y-4">
          @foreach ($cartItems as $item)
            <div class="flex justify-between items-center gap-2 p-2 border-b border-gray-200 ">
              <div>
                <img src="{{ Storage::url('products/' . $item->product->firstImage->image) }}" alt=""
                  class="w-20 h-20">
              </div>
              <div class="flex-1">
                <h3 class="text-lg text-green-700 font-medium">{{ $item->product->name }}</h3>
                <div class="flex text-gray-500">
                  <p class="">${{ $item->product->price }} × </p>
                  <input type="number" wire:model.defer="quantities.{{ $item->id }}"
                    wire:change="updateQuantity({{ $item->id }}, $event.target.value)"
                    class="w-16 p-0 px-0.5 border-0 border-b border-gray-200 focus:outline-0 focus:ring-0" min="1">
                  {{-- <!-- Quantity Input --> --}}

                </div>
                <p class="text-gray-500">Total: ${{ $item->product->price * $item->quantity }}</p>
              </div>
              <button wire:click="removeFromCart({{ $item->id }})" class="text-red-500 hover:text-red-700">
                <i class="fa-regular fa-trash-can w-5 h-5"></i>
              </button>
            </div>
          @endforeach

          <!-- Cart Total Price -->
          <div class="mt-4 p-2 border-t">
              <h2 class="text-lg font-bold flex justify-between">Total Price: <span>${{ number_format($totalPrice, 2) }}</span></h2>
          </div>
        </div>

        <div class="mt-6">
          <button class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Checkout</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Cart Toggle Button -->
  <button @click="isOpen = true" class="">
    <span class="fa-layers fa-fw text-2xl">
      <i class="fa-solid fa-shopping-basket"></i>
      <span class="fa-layers-counter text-3xl">{{ count($cartItems) }}</span>
    </span>
  </button>
</div>
