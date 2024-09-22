<div class="px-10">

  <div class="flex md:flex-row flex-col gap-10 mt-10">

    <div class="w-1/2">
      <div class="border relative p-3">
        @if($product->price != $product->price_after_discount)
        <span class="fa-layers fa-fw fa-4x z-10 absolute top-3 left-2">
          <i class="fa-solid fa-tag text-green-400"></i>
          <span class="fa-layers-text fa-inverse font-bold" data-fa-transform="shrink-11.5 rotate--30">%</span>
        </span>
        @endif
        <img src="{{ Storage::url("products/" . $product->images[0]->image) }}" id="preview-img">
      </div>
      <div class="flex overflow-x-scroll gap-5 mt-5">
        @foreach($product->images as $image)
        <img src="{{ Storage::url("products/" . $image->image) }}" class="w-40 h-40 product-img opacity-50 hover:opacity-100 duration-300 cursor-pointer">
        @endforeach
      </div>
    </div>

    <div class="flex-1">
      <div class="pt-1 mb-3">
        @if($product->quantity > 0)
        <label class="px-3 py-1 bg-green-200 uppercase">In Stock</label>
        @else
        <label class="px-3 py-1 bg-red-200 uppercase">out of Stock</label>
        @endif
      </div>
      <h1 class="text-3xl font-bold text-green-700">{{ $product->name }}</h1>
      <h1 class="text-2xl font-bold text-yellow-700">
        @if($product->price !== $product->price_after_discount)
        <span class="line-through text-gray-500">{{ $product->price }}$</span> <span class="no-underline text-red-600">{{  $product->price_after_discount }}$</span>
        <label class="block">Discount: {{ $product->discount }}</label>
        @else
        <span>{{ $product->price }}$</span>
        @endif
      </h1>
      <p class="mt-5">{{ $product->mini_description }}</p>
      
      <div class="flex gap-3 mt-7">
        <input type="number" name="quantity" class="rounded-full bg-transparent w-24 ps-4" value="1">
        <button class="rounded-full bg-green-600 px-10 py-2 font-bold text-white uppercase hover:bg-green-800">Add To Cart</button>
      </div>

      <div class="text-sm mt-10">
        <label class="block text-gray-400"><span class="text-black">SKU:</span> {{ $product->sku }}</label>
        <label class="block text-gray-400">
          <span class="text-black">Categories:</span>
          @foreach($product->categories as $key => $category)
          <a href="{{ route("products", ["category" => $category->slug]) }}" class="text-green-700 hover:text-green-500">{{ $category->name }}</a>{{ count($product->categories) - 1  > $key ? "," : "" }}
          @endforeach
        </label>
      </div>
    </div>

  </div>

  <div class="mt-5">
    <h2 class="text-2xl font-bold mb-3">Description</h2>
    <p>{!! $product->description !!}</p>
  </div>

  <div class="mt-5 pb-5">
    <h2 class="text-2xl font-bold mb-3">Reviews</h2>
    @forelse($product->reviews as $review)
    @empty
    <h3 class="text-xl">No Reviews</h3>
    @endforelse
  </div>
</div>

@push('scripts')
<script type="text/javascript">
  $(document).ready(function() {
    changeImg($('.product-img')[0]);

    $(document).on('click', '.product-img', function(event) {
      event.preventDefault();
      /* Act on the event */
      changeImg($(this));
    });

    function changeImg(img) {
      src = $(img).attr("src");
      $(".product-img").addClass('opacity-50');
      $(img).removeClass('opacity-50');
      $("#preview-img").attr("src", src);
    }
  });
</script>
@endpush