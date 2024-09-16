<div>
  <div style="background-image: url({{ asset("images/$image_name-background.png") }});" class="h-60 bg-no-repeat bg-cover bg-center flex md:justify-start justify-center items-center px-10">
    <h2 class="text-4xl text-center text-white font-bold text-shadow-lg shadow-black capitalize">{{ $name }}</h2>
  </div>

  <div x-data="{ openFilters: false }" class="flex">

    {{-- Filters - Visible on Large Screens, Toggle on Mobile --}}
    <div 
        :class="{'-translate-x-full': !openFilters, 'translate-x-0': openFilters}" 
        class="fixed top-0 left-0 w-2/3 lg:h-auto h-full lg:w-1/6 bg-white border-e-2 shadow-xl z-50 transition-transform duration-300 lg:static lg:translate-x-0"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="transform -translate-x-full"
        x-transition:enter-end="transform translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="transform translate-x-0"
        x-transition:leave-end="transform -translate-x-full">
        <div class="flex justify-end h-10 px-5 md:hidden">
          <button @click="openFilters = !openFilters"><i class="fa-solid fa-xmark"></i></button>
        </div>
      <livewire:product-filter :category="$category" />
    </div>

    {{-- Products Section --}}
    <div class="w-full min-h-screen lg:w-5/6 p-5">
      {{-- Toggle Button - Visible only on Mobile --}}
      <button @click="openFilters = !openFilters" class="bg-gray-500 text-white px-4 py-2 mx-5 rounded-md mb-4 block lg:hidden">
        <span><i class="fa-solid fa-sliders"></i></span>
      </button>
      <div class="h-60 flex items-center justify-center hidden" wire:loading.class.remove="hidden">
        <i class="fa-solid fa-store fa-7x fa-beat text-green-700"></i>
      </div>
      <div class="flex justify-center flex-wrap gap-5" wire:loading.class="hidden">
        @forelse($products as $product)
        <a href="{{ route("product-details", $product->slug) }}" class="w-1/4 relative group pb-3 hover:bg-gray-200  duration-300" wire:navigate>
          <div>
            <div class="relative">
              <img src="{{ Storage::url("products/" . $product->images[0]->image) }}" class="w-full">
              @if($product->images->count() > 1)
              <img src="{{ Storage::url("products/" . $product->images[1]->image) }}" class="w-full absolute top-0 left-0 opacity-0 group-hover:opacity-100 duration-300">
              @endif
            </div>
            <h1 class="text-center mt-2">{{ $product->name }}</h1>
            <div class="text-center">
              @foreach($product->categories as $category)
              <label>{{ $category->name }}</label>
              @endforeach
            </div>
            <label class="block text-center">{{ $product->price }}$</label>
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
