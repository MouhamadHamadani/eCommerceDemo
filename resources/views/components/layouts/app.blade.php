<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $title ?? 'Page Title' }} {{ ' | ' . config('app.name', 'Laravel') }}</title>

  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset("apple-touch-icon.png") }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset("favicon-32x32.png") }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset("favicon-16x16.png") }}">
  <link rel="manifest" href="{{ asset("site.webmanifest") }}">

  <!-- Fonts -->
  {{-- <link rel="preconnect" href="https://fonts.bunny.net"> --}}
  {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <link rel="stylesheet" type="text/css" href="{{ asset("css/all.css") }}">
  <link rel="stylesheet" type="text/css" href="{{ asset("css/main.css") }}">
  @stack('style')

  <!-- Styles -->
  @livewireStyles
</head>
<body class="font-sans antialiased">
  <x-banner />

  <div class="min-h-screen bg-gray-100">
    @livewire('navigation-menu-main')

    <!-- Page Heading -->
    {{-- @if (isset($header))
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{ $header }}
      </div>
    </header>
    @endif --}}

    <!-- Page Content -->
    <main class="">
      {{ $slot }}
    </main>
  </div>

  <footer class="bg-gray-800 text-white py-10 sm:px-0 px-5">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-10">
      <!-- About Section -->
      <div>
        <h3 class="text-lg font-semibold mb-3">About Us</h3>
        <p class="text-gray-400">
          We provide top-notch products with quality services for all your needs. Your satisfaction is our priority.
        </p>
      </div>

      <!-- Quick Links Section -->
      <div>
        <h3 class="text-lg font-semibold mb-3">Quick Links</h3>
        <ul class="text-gray-400 space-y-2">
          <li><a href="{{ route("home") }}" class="hover:text-gray-200" wire:navigate>Home</a></li>
          <li><a href="{{ route("products") }}" class="hover:text-gray-200" wire:navigate>Shop</a></li>
          <li><a href="#" class="hover:text-gray-200">About Us</a></li>
          <li><a href="#" class="hover:text-gray-200">Contact Us</a></li>
        </ul>
      </div>

      <!-- Customer Service Section -->
      <div>
        <h3 class="text-lg font-semibold mb-3">Customer Service</h3>
        <ul class="text-gray-400 space-y-2">
          <li><a href="#" class="hover:text-gray-200">FAQs</a></li>
          <li><a href="#" class="hover:text-gray-200">Shipping & Returns</a></li>
          <li><a href="#" class="hover:text-gray-200">Privacy Policy</a></li>
          <li><a href="#" class="hover:text-gray-200">Terms of Service</a></li>
        </ul>
      </div>

      <!-- Contact Info Section -->
      <div>
        <h3 class="text-lg font-semibold mb-3">Contact Us</h3>
        <p class="text-gray-400 mb-2">Phone: +961 3 123456</p>
        <p class="text-gray-400 mb-2">Email: info@yourstore.com</p>
        <div class="flex space-x-4 mt-4">
          <a href="#" class="hover:text-gray-200">
            <i class="fa-brands fa-facebook w-6 h-6 text-white"></i>
          </a>
          <a href="#" class="hover:text-gray-200">
            <i class="fa-brands fa-x-twitter w-6 h-6 text-white"></i>
          </a>
          <a href="#" class="hover:text-gray-200">
            <i class="fa-brands fa-instagram w-6 h-6 text-white"></i>
          </a>
          <a href="#" class="hover:text-gray-200">
            <i class="fa-brands fa-tiktok w-6 h-6 text-white"></i>
          </a>
        </div>
      </div>
    </div>

    <!-- Copyright Section -->
    <div class="mt-10 border-t border-gray-700 pt-6 text-center text-gray-500">
      © {{ date("Y") }} YourStore. All Rights Reserved.
    </div>
  </footer>


  @stack('modals')

  @livewireScripts

  <script type="text/javascript" src="{{ asset("js/jquery.js") }}"></script>
  <script type="text/javascript" src="{{ asset("js/all.js") }}"></script>
  @stack('scripts')
</body>
</html>
