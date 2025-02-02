<div>
  @if (count($products) > 0)
    <div class="py-10 bg-white text-center">

      <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl mb-5 text-green-700 font-bold">
        <span class="fa-layers fa-fw fa-beat">
          <i class="fa-solid fa-certificate text-red-400"></i>
          <span class="fa-layers-text fa-inverse font-bold" data-fa-transform="shrink-11.5 rotate--30">NEW</span>
        </span>
        New Products
        <span class="fa-layers fa-fw fa-beat">
          <i class="fa-solid fa-certificate text-red-400"></i>
          <span class="fa-layers-text fa-inverse font-bold" data-fa-transform="shrink-11.5 rotate--30">NEW</span>
        </span>
      </h1>

      <div class="flex justify-center gap-5">
        @foreach ($products as $product)
          <a href="{{ route('product-details', $product->slug) }}"
            class="w-1/4 relative group hover:bg-gray-200  duration-300" wire:navigate>
            <div class="border p-2 hover:p-1 duration-300 rounded shadow">
              <img src="{{ Storage::url('products/' . $product->firstImage->image) }}" alt="{{ $product->name }}"
                class="w-full object-cover rounded">

              <h3 class="mt-2 font-bold">{{ $product->name }}</h3>
              @if ($product->price !== $product->price_after_discount)
                <span class="line-through text-gray-500">{{ number_format($product->price, 2) }}$</span> <span
                  class="no-underline text-red-600">{{ number_format($product->price_after_discount, 2) }}$</span>
              @else
                <span>{{ number_format($product->price, 2) }}$</span>
              @endif
            </div>
          </a>
        @endforeach
      </div>

    </div>
  @endif
</div>
