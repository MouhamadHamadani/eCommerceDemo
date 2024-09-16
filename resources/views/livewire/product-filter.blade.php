<div x-data="{ openCategories: false, openPrice: false }">
@php $lang = app()->getLocale() @endphp
  <!-- Category Accordion -->
  <div class="p-4 border-b">
    <h2 @click="openCategories = !openCategories"
      class="text-lg font-semibold mb-4 cursor-pointer flex justify-between items-center">
      {{ __("Filter by Category") }}
      <svg :class="{ 'rotate-180': openCategories }" class="w-5 h-5 transform transition-transform"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </h2>
    <div x-show="openCategories" class="mt-2" x-cloak>
      @foreach ($categories as $category)
        <div class="me-4 mb-2">
          <label class="inline-flex items-center">
            <input type="checkbox" wire:click="updateCategories" wire:model="selectedCategories"
              value="{{ $category->slug }}" class="form-checkbox">
            <span class="ms-2">{{ $category->name }}</span>
          </label>
        </div>
      @endforeach
    </div>
  </div>

  <div class="p-4 border-b">
    <h2 @click="openPrice = !openPrice" class="text-lg font-semibold mb-4 cursor-pointer flex justify-between items-center">
      Filter by Price
      <svg :class="{ 'rotate-180': openPrice }" class="w-5 h-5 transform transition-transform"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </h2>
    <div x-show="openPrice" class="grid grid-cols-2 w-full gap-2">
      <x-input placeholder="Min" wire:model="price_min" wire:change="updatePrice"/>
      <x-input placeholder="Max" wire:model="price_max" wire:change="updatePrice"/>
    </div>
  </div>

  <!-- Reset Filters Button -->
  <button wire:click="resetFilters" class="bg-red-500 text-white px-4 py-2 rounded-md mx-4 my-4">{{ __("Reset Filters") }}</button>
</div>
