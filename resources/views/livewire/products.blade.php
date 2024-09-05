<div>
  <h2 class="text-2xl my-5 text-center">Products</h2>
  <div class="flex justify-center flex-wrap gap-5 p-5">
    @forelse($products as $product)
    <a href="" class="w-1/4 relative group pb-3 hover:bg-gray-200  duration-300">
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
</div>
