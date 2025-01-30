@push('style')
<link rel="stylesheet" type="text/css" href="{{ asset("css/swiper.css") }}">
@endpush
<div>
  <!-- Swiper -->
  <div class="swiper mySwiper">
    <div class="swiper-wrapper">
      @foreach($slides as $slide)
      <div class="swiper-slide">
        <div class="relative">
          @if($slide->description != null || $slide->title != null || $slide->link != null)
          <div class="absolute lg:w-1/2 h-full flex justify-center items-start flex-col gap-5 px-16">
            @if($slide->title != null)
            <h1 class="lg:text-6xl text-xl font-black">{{ $slide->title }}</h1>
            @endif
            @if($slide->description != null)
            <p class="md:block hidden lg:text-base text-xs">{{ $slide->description }}</p>
            @endif
            @if($slide->link != null)
            <a href="{{ $slide->link }}" wire:navigate><button class="bg-green-600 hover:bg-green-700 duration-300 text-white px-10 py-2 rounded-full">Shop Now</button></a>
            @endif
          </div>
          @endif
          <img class="w-full" src="{{ asset("images/" . $slide->image) }}">
        </div>
      </div>
      @endforeach
    </div>
    <div class="swiper-button-next !text-green-600"></div>
    <div class="swiper-button-prev !text-green-600"></div>
  </div>

  <div class="mt-5 text-center">
    <h2 class="text-3xl font-bold mb-5">Main Categories</h2>
    <div class="flex justify-center flex-wrap mts-5">
      @forelse($categories as $category)
      <a href="{{ url("products?category=" . $category->slug) }}" class="2xl:w-[20%] md:w-1/4 w-1/2 group" wire:navigate>
        <div class="relative group">
          <img src="{{ Storage::url("categories/" . $category->image) }}" class="w-full">
          <label class="absolute right-4 md:top-1/2 top-1/3 w-1/2 text-3xl font-black text-white group-hover:text-shadow-lg shadow-black text-end duration-300 group-hover:right-7">{{ $category->name }}</label>
        </div>
      </a>
      @empty
      <label>No Categories Found</label>
      @endif
    </div>
  </div>

  <div class="flex justify-center gap-5 hidden">
    @forelse($products as $product)
    <div>
      <label>{{ $product->name }}</label>
      <img src="{{ Storage::url("products/" . $product->images[0]->image) }}" class="w-full">
      <label>{{ $product->price }}$</label>
      <label>{{ $product->quantity }}</label>
    </div>
    @empty
    <label>No Products Found</label>
    @endif
  </div>
</div>

@push('scripts')
<script type="text/javascript" src="{{ asset("js/swiper.js") }}"></script>
<script>
  var swiper = new Swiper(".mySwiper", {
    autoplay: {
      delay: 3500,
      disableOnInteraction: false,
    },
    effect: "fade",
    loop: true,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
</script>
@endpush