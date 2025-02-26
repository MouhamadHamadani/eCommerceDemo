<nav x-data="{ open: false }"
  class="@if (request()->routeIs('home')) bg-transparent md:absolute w-full top-0 z-10 @else bg-white border-b border-gray-100 @endif">
  <!-- Primary Navigation Menu -->
  <div class=" px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
      <div class="flex">
        <!-- Logo -->
        <div class="shrink-0 flex items-center">
          @persist('logo')
            <a href="{{ route('home') }}">
              <x-application-mark class="block h-16 w-auto" />
            </a>
          @endpersist
        </div>

        <!-- Navigation Links -->
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
          <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
            {{ __('Home') }}
          </x-nav-link>
          <div
            class="relative group inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500">
            <x-nav-link href="{{ route('products') }}" class="h-full" :active="request()->routeIs('products')">
              {{ __('Shop') }}
            </x-nav-link>
            <div
              class="absolute top-16 w-max px-3 py-3 opacity-0 hidden bg-white left-0 duration-300 group-hover:block group-hover:opacity-100 group-hover:top-16 border-b-2 border-green-800 z-10">
              <h2 class="font-black mb-5">Categories</h2>
              <div class="grid grid-cols-3 gap-x-5 gap-y-3">
                @forelse($categories as $category)
                  <div class="">
                    <a href="{{ route('products', ['category' => $category->slug]) }}" class="font-bold"
                      wire:navigate>{{ $category->name }}</a>
                    <x-sub-category-link :category="$category" />
                  </div>
                @empty
                  <label>No Categories Found</label>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="hidden sm:flex sm:items-center sm:ms-6">
        @auth
          <!-- Teams Dropdown -->
          @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
            <div class="ms-3 relative">
              <x-dropdown align="right" width="60">
                <x-slot name="trigger">
                  <span class="inline-flex rounded-md">
                    <button type="button"
                      class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                      {{ Auth::user()->currentTeam->name }}

                      <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                      </svg>
                    </button>
                  </span>
                </x-slot>

                <x-slot name="content">
                  <div class="w-60">
                    <!-- Team Management -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                      {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                      {{ __('Team Settings') }}
                    </x-dropdown-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                      <x-dropdown-link href="{{ route('teams.create') }}">
                        {{ __('Create New Team') }}
                      </x-dropdown-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                      <div class="border-t border-gray-200"></div>

                      <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                      </div>

                      @foreach (Auth::user()->allTeams() as $team)
                        <x-switchable-team :team="$team" />
                      @endforeach
                    @endif
                  </div>
                </x-slot>
              </x-dropdown>
            </div>
          @endif
        @endauth

        <div>
          {{-- <span class="fa-layers fa-fw text-2xl">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="fa-layers-counter">{{ count($cartItems) }}</span>
          </span> --}}

          @livewire('sidebar-cart')
          {{-- <i class="fa-solid fa-cart-shopping"></i> {{ count($cartItems) }} --}}
        </div>
        <!-- Settings Dropdown -->
        <div class="ms-3 relative">
          <x-dropdown align="right" width="48">
            <x-slot name="trigger">
              @auth
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                  <button
                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                      alt="{{ Auth::user()->name }}" />
                  </button>
                @else
                  <span class="inline-flex rounded-md">
                    <button type="button"
                      class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                      {{ Auth::user()->name }}

                      <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                      </svg>
                    </button>
                  </span>
                @endif
              @else
                <button
                  class="flex text-sm border-2 border-gray-100/50 rounded-full focus:outline-none focus:border-gray-300 transition p-2">
                  <i class="fa-solid fa-user text-lg"></i>
                </button>
              @endauth
            </x-slot>

            <x-slot name="content">
              @auth
                <!-- Account Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                  {{ __('Manage Account') }}
                </div>

                <x-dropdown-link href="{{ route('profile.show') }}">
                  {{ __('Profile') }}
                </x-dropdown-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                  <x-dropdown-link href="{{ route('api-tokens.index') }}">
                    {{ __('API Tokens') }}
                  </x-dropdown-link>
                @endif

                <div class="border-t border-gray-200"></div>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                  @csrf

                  <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                    {{ __('Log Out') }}
                  </x-dropdown-link>
                </form>
              @else
                <x-dropdown-link href="{{ route('login') }}">
                  {{ __('Login') }}
                </x-dropdown-link>
                <x-dropdown-link href="{{ route('register') }}">
                  {{ __('Register') }}
                </x-dropdown-link>
              @endauth
            </x-slot>
          </x-dropdown>
        </div>
      </div>

      <!-- Hamburger -->
      <div class="-me-2 flex items-center sm:hidden">
        <button @click="open = ! open"
          class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
              stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Responsive Navigation Menu -->
  <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
      <x-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
        {{ __('Home') }}
      </x-responsive-nav-link>
      <div x-data="{ open: false }">
        <x-responsive-nav-link href="{{ route('products') }}" :active="request()->routeIs('products')">
          {{ __('Shop') }}
        </x-responsive-nav-link>

        <button @click="open = !open" class="w-full ps-3 pe-4 py-2 border-l-4 border-transparent flex justify-between items-center text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50">
          Browse Categories
          <span x-text="open ? '▲' : '▼'"></span>
        </button>

        <div x-show="open" class="pl-4 border-l border-gray-300">
          @foreach ($categories->take(5) as $category)
            <!-- Show only top 5 -->
            <a href="{{ route('products', ['category' => $category->slug]) }}" class="block px-4 py-2 text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50">
              {{ $category->name }}
            </a>
          @endforeach
          <a href="{{ route('products') }}?openFilter=true" class="block px-4 py-2 text-green-600 font-bold">
            View All Categories →
          </a>
        </div>
      </div>
    </div>

    <!-- Responsive Settings Options -->
    <div class="pt-4 pb-1 border-t border-gray-200">
      @auth
        <div class="flex items-center px-4">
          @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div class="shrink-0 me-3">
              <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                alt="{{ Auth::user()->name }}" />
            </div>
          @endif

          <div>
            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
          </div>
        </div>

        <div class="mt-3 space-y-1">
          <!-- Account Management -->
          <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
            {{ __('Profile') }}
          </x-responsive-nav-link>

          @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
            <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
              {{ __('API Tokens') }}
            </x-responsive-nav-link>
          @endif

          <!-- Authentication -->
          <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf

            <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
              {{ __('Log Out') }}
            </x-responsive-nav-link>
          </form>

          <!-- Team Management -->
          @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
            <div class="border-t border-gray-200"></div>

            <div class="block px-4 py-2 text-xs text-gray-400">
              {{ __('Manage Team') }}
            </div>

            <!-- Team Settings -->
            <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
              {{ __('Team Settings') }}
            </x-responsive-nav-link>

            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
              <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                {{ __('Create New Team') }}
              </x-responsive-nav-link>
            @endcan

            <!-- Team Switcher -->
            @if (Auth::user()->allTeams()->count() > 1)
              <div class="border-t border-gray-200"></div>

              <div class="block px-4 py-2 text-xs text-gray-400">
                {{ __('Switch Teams') }}
              </div>

              @foreach (Auth::user()->allTeams() as $team)
                <x-switchable-team :team="$team" component="responsive-nav-link" />
              @endforeach
            @endif
          @endif
        </div>
      @else
        <x-responsive-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
          {{ __('Login') }}
        </x-responsive-nav-link>
        @if (Route::has('register'))
          <x-responsive-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
            {{ __('Register') }}
          </x-responsive-nav-link>
        @endif
      @endauth
    </div>
  </div>
</nav>
