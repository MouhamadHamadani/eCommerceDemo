<div class="py-5 text-center">

  <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl mb-5 text-green-700 font-bold">
    <span class="fa-layers fa-fw">
      <i class="fa-solid fa-tag text-green-400"></i>
      <span class="fa-layers-text fa-inverse font-bold" data-fa-transform="shrink-11.5 rotate--30">%</span>
    </span>
    Top 10 Discounted Products
    <span class="fa-layers fa-fw">
      <i class="fa-solid fa-tag text-green-400"></i>
      <span class="fa-layers-text fa-inverse font-bold" data-fa-transform="shrink-11.5 rotate--30">%</span>
    </span>
  </h1>

  <div class="flex justify-center gap-5 sm:mx-10">
    @foreach ($products as $product)
      <a href="{{ route('product-details', $product->slug) }}"
        class="sm:w-1/4 w-3/4 relative group hover:bg-gray-200  duration-300" wire:navigate>
        <div class="border p-2 hover:p-1 duration-300 rounded shadow relative">

          <span
            class="fa-layers fa-fw fa-4x z-10 absolute group-hover:top-2 group-hover:right-0 duration-300 top-3 right-0.5">
            <i class="fa-solid fa-tag text-green-400 " data-fa-transform="rotate-45"></i>
            <span class="fa-layers-text fa-inverse font-bold" data-fa-transform="shrink-13.5">
                {{ $product->discount }}
            </span>
          </span>
          <img src="{{ Storage::url('products/' . $product->firstImage->image) }}" alt="{{ $product->name }}"
            class="w-full object-cover rounded">

          <h3 class="mt-2 font-bold">{{ $product->name }}</h3>
          <span class="line-through text-gray-500">{{ number_format($product->price, 2) }}$</span> <span
            class="no-underline text-red-600">{{ $product->price_after_discount != 0 ? number_format($product->price_after_discount, 2) . "$" : "Free" }}</span>
          <p class="mt-2">
            <span class="countdown font-semibold text-black"
              data-end="{{ \Carbon\Carbon::parse($product->discount_end_date)->format('Y-m-d H:i:s') }}"></span>
          </p>
        </div>
      </a>
    @endforeach
  </div>

  <!-- Pagination -->
  <div class="mt-4">
    {{ $products->links() }}
  </div>

  <!-- Countdown Timer Script -->
  <script>
    function updateCountdown() {
      document.querySelectorAll('.countdown').forEach(function(element) {
        let endDate = new Date(element.getAttribute('data-end')).getTime();
        let now = new Date().getTime();
        let timeLeft = endDate - now;

        if (timeLeft > 0) {
          let days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
          let hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
          let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

          // Ensure all values have two digits (e.g., 01, 09, etc.)
          let formattedDays = String(days).padStart(2, '0');
          let formattedHours = String(hours).padStart(2, '0');
          let formattedMinutes = String(minutes).padStart(2, '0');
          let formattedSeconds = String(seconds).padStart(2, '0');

          element.innerHTML =
            `${formattedDays} days <span class="bg-green-400 rounded text-white px-1">${formattedHours}</span>:<span class="bg-green-400 rounded text-white px-1">${formattedMinutes}</span>:<span class="bg-green-400 rounded text-white px-1">${formattedSeconds}</span>`;
        } else {
          element.innerHTML = "Expired";
        }
      });
    }

    setInterval(updateCountdown, 1000);
    updateCountdown(); // Run immediately on page load
  </script>

</div>
