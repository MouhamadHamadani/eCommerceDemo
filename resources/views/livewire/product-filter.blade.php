<div x-data="{ openSpecializations: false, openLocation: false, openGovernorates: false, openDistricts: false, openCities: false }">
@php $lang = app()->getLocale() @endphp
  <!-- Specialization Accordion -->
  <div class="p-4 border-b">
    <h2 @click="openSpecializations = !openSpecializations"
      class="text-lg font-semibold mb-4 cursor-pointer flex justify-between">
      {{ __("Filter by Specialization") }}
      <svg :class="{ 'rotate-180': openSpecializations }" class="w-5 h-5 transform transition-transform"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </h2>
    <div x-show="openSpecializations" class="mt-2" x-cloak>
      @foreach ($categories as $category)
        <div class="me-4 mb-2">
          <label class="inline-flex items-center">
            <input type="checkbox" wire:click="updateSpecializations" wire:model="selectedSpecializations"
              value="{{ $category->id }}" class="form-checkbox">
            <span class="ms-2">{{ $category->name }}</span>
          </label>
        </div>
      @endforeach
    </div>
  </div>

  <!-- Location Accordion -->
  <div class="p-4 border-b">
    <h2 @click="openLocation = !openLocation" class="text-lg font-semibold mb-4 cursor-pointer flex justify-between">
      {{ __("Filter by Location") }}
      <svg :class="{ 'rotate-180': openLocation }" class="w-5 h-5 transform transition-transform"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
      </svg>
    </h2>
    <div x-show="openLocation" class="mt-2" x-cloak>
      <!-- Governorate Filter -->
      <div class="mb-4">
        <label @click="openGovernorates = !openGovernorates"
          class="text-sm font-medium text-gray-700 cursor-pointer flex justify-between">
          {{ __("Governorates") }}
          <svg :class="{ 'rotate-180': openGovernorates }" class="w-5 h-5 transform transition-transform"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </label>
        <div x-show="openGovernorates" class="flex flex-wrap mt-2" x-cloak>
          @foreach ($governorates as $governorate)
          @php $name = json_decode($governorate->name) @endphp
            <div class="me-4 mb-2">
              <label class="inline-flex items-center">
                <input type="checkbox" wire:click="updateDistricts" wire:model="selectedGovernorates"
                  value="{{ $governorate->id }}" class="form-checkbox">
                <span class="ms-2">{{ $name->$lang }}</span>
              </label>
            </div>
          @endforeach
        </div>
      </div>
      
      <!-- District Filter -->
      <div class="mb-4" x-cloak>
        <label @click="openDistricts = !openDistricts"
          class="text-sm font-medium text-gray-700 cursor-pointer flex justify-between">
          {{ __("Districts") }}
          <svg :class="{ 'rotate-180': openDistricts }" class="w-5 h-5 transform transition-transform"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </label>
        <div x-show="openDistricts" class="flex flex-wrap mt-2" x-cloak>
            @forelse ($districts as $district)
            @php $name = json_decode($district->name) @endphp
              <div class="me-4 mb-2">
                <label class="inline-flex items-center">
                  <input type="checkbox" wire:click="updateCities" wire:model="selectedDistricts"
                    value="{{ $district->id }}" class="form-checkbox">
                  <span class="ms-2">{{ $name->$lang }}</span>
                </label>
              </div>
              @empty
              <div class="me-4 mb-2">
                <label class="inline-flex items-center">
                    {{ __("Choose Governorate") }}
                </label>
              </div>
            @endforelse
        </div>
      </div>

      <!-- City Filter -->
      <div class="mb-4" x-cloak>
        <label @click="openCities = !openCities"
          class="text-sm font-medium text-gray-700 cursor-pointer flex justify-between">
          {{ __("Cities") }}
          <svg :class="{ 'rotate-180': openCities }" class="w-5 h-5 transform transition-transform"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
        </label>
        <div x-show="openCities" class="flex flex-wrap mt-2" x-cloak>
          @forelse ($cities as $city)
          @php $name = json_decode($city->name) @endphp
            <div class="me-4 mb-2">
              <label class="inline-flex items-center">
                <input type="checkbox" wire:click="updateCities" wire:model="selectedCities" value="{{ $city->id }}"
                  class="form-checkbox">
                <span class="ms-2">{{ $name->$lang }}</span>
              </label>
            </div>
          @empty
          <div class="me-4 mb-2">
            <label class="inline-flex items-center">
                {{ __("Choose District") }}
            </label>
          </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <!-- Reset Filters Button -->
  <button wire:click="resetFilters" class="bg-red-500 text-white px-4 py-2 rounded-md mx-4 my-4">{{ __("Reset Filters") }}</button>
</div>
