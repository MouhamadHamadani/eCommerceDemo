<div>
  <div style="background-image: url({{ asset("images/$image_name-background.png") }});" class="h-60 bg-no-repeat bg-cover bg-center flex md:justify-start justify-center items-center px-10">
    <h2 class="text-4xl text-center text-white font-bold text-shadow-lg shadow-black capitalize">{{ $name }}</h2>
  </div>

  <div x-data="{ openFilters: {{ $openFilter == true ? 'true' : 'false' }} }" class="flex">

    {{-- Filters - Visible on Large Screens, Toggle on Mobile --}}
    <div 
        :class="{'-translate-x-full': !openFilters, 'translate-x-0': openFilters}" 
        class="fixed top-0 left-0 w-2/3 lg:h-auto h-full lg:w-1/6 bg-white border-e-2 shadow-xl z-20 transition-transform duration-300 lg:static lg:translate-x-0"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="transform -translate-x-full"
        x-transition:enter-end="transform translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="transform translate-x-0"
        x-transition:leave-end="transform -translate-x-full">
        <div class="flex justify-end h-10 px-5 md:hidden">
          <button @click="openFilters = !openFilters"><i class="fa-solid fa-xmark"></i></button>
        </div>
      <livewire:product-filter :category="$category" :price_min="$price_min" :price_max="$price_max" />
    </div>

    {{-- Products Section --}}
    <div class="w-full min-h-screen lg:w-5/6 p-5">
      {{-- Sorting --}}
      <div class="flex lg:justify-end justify-between mb-5">
        {{-- Toggle Button - Visible only on Mobile --}}
        <button @click="openFilters = !openFilters" class="bg-gray-500 text-white px-4 py-2 mx-5 rounded-md mb-4 block lg:hidden">
          <span><i class="fa-solid fa-sliders"></i></span>
        </button>
        <label>
          Sort By:
          <select class="rounded-md border-gray-300 pe-10 py-1 bg-{{ __('right') }}" wire:model="sorting"
          wire:change="changeSorting">
            <option value="all">{{ __('None') }}</option>
            <option value="price_low">{{ __('Price Low to High') }}</option>
            <option value="price_high">{{ __('Price High to Low') }}</option>
            <option value="a_z">{{ __('A to Z') }}</option>
            <option value="z_a">{{ __('Z to A') }}</option>
          </select>
        </label>
      </div>
      <div class="h-60 flex items-center justify-center hidden" wire:loading.class.remove="hidden">
        <i class="fa-solid fa-store fa-7x fa-beat text-green-700"></i>
      </div>
      {{-- Sorting --}}
      <div class="flex justify-center flex-wrap" wire:loading.class="hidden">
        @forelse($products as $product)
        <a href="{{ route("product-details", $product->slug) }}" class="lg:w-1/4 sm:w-1/3 w-1/2 p-2 relative" wire:navigate>  
          <div class="border hover:border-green-500 p-2 hover:p-1 duration-300 rounded shadow group hover:bg-gray-200">
            <div class="relative">
              @if(!$product->created_at->lt(Carbon\Carbon::now()->subWeek()))
              <span class="fa-layers fa-fw fa-beat fa-3x z-10 absolute top-1 right-1">
                <i class="fa-solid fa-certificate text-red-400"></i>
                <span class="fa-layers-text fa-inverse font-bold" data-fa-transform="shrink-11.5 rotate--30">NEW</span>
              </span>
              @endif
              @if($product->quantity <= 0)
              <div class="absolute bottom-0 w-full bg-red-500 text-center text-white z-10 font-bold py-1">
                Out Of Stock
              </div>
              @endif
              @if($product->price != $product->price_after_discount)
              <span class="fa-layers fa-fw fa-3x z-10 absolute top-1 left-1">
                <i class="fa-solid fa-tag text-green-400"></i>
                <span class="fa-layers-text fa-inverse font-bold" data-fa-transform="shrink-11.5 rotate--30">%</span>
              </span>
              @endif
              <img src="{{ Storage::url("products/" . $product->firstImage->image) }}" class="w-full object-cover">
              @if($product->images->count() > 1)
              <img src="{{ Storage::url("products/" . $product->images[1]->image) }}" class="w-full object-cover absolute top-0 left-0 opacity-0 group-hover:opacity-100 duration-300">
              @endif
            </div>
            <h1 class="text-center mt-2">{{ $product->name }}</h1>
            <div class="text-center flex flex-wrap justify-center gap-2 text-green-600">
              @foreach($product->categories as $category)
              <label class="text-sm">{{ $category->name }}</label>
              @endforeach
            </div>
            <label class="block text-center">
            @if($product->price !== $product->price_after_discount)
              <span class="line-through text-gray-500">{{ $product->price }}$</span> <span class="no-underline text-red-600">{{  $product->price_after_discount != 0 ? $product->price_after_discount . "$" : "Free" }}</span>
            @else
              <span>{{ $product->price }}$</span>
            @endif
            </label>
          </div>
        </a>
        @empty
        <label>No Products Found</label>
        @endif
      </div>
      <div class="flex md:justify-end justify-center mt-5 px-5">
        {{ $products->links() }}
      </div>
    </div>
  </div>
</div>
