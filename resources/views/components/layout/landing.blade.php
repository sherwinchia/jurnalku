<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @yield('meta-content')

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> -->

  <!--Favicon-->
  <!-- <link rel="icon" type='image/x-icon' href="{{ asset('images/brand/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/brand/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/brand/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/brand/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/brand/site.webmanifest') }}">  -->

  <!-- Styles -->
  <link rel="stylesheet" href="{{ mix('css/user.css') }}">
  @livewireStyles

  <!-- Scripts -->
  <script src="{{ mix('js/user.js') }}" defer></script>
</head>

<body class="font-sans antialiased">
  <div class="fixed inset-x-0 top-0 z-50 w-full bg-white border-b border-gray-300">
    <div x-data="{ open: false }"
      class="flex flex-col px-4 py-4 mx-auto max-w-7xl md:items-center md:justify-between md:flex-row md:px-6 lg:px-0">
      <div class="flex flex-row items-center justify-between">
        <a href="{{ route('user.home.index') }}"
          class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg focus:outline-none focus:shadow-outline">{{ ucfirst(config('app.name')) }}</a>
        <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open">
          <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
            <path x-show="!open" fill-rule="evenodd"
              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
              clip-rule="evenodd"></path>
            <path x-show="open" fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
          </svg>
        </button>
      </div>
      <nav :class="{'flex': open, 'hidden': !open}"
        class="flex-col items-start flex-grow hidden pb-4 md:pb-0 md:flex md:justify-end md:flex-row md:items-center ">
        {{-- <a href="{{ route('user.home.index') }}" class="px-2 py-1 mt-2 md:mt-0 md:ml-4">
          Home
        </a> --}}
        <a href="{{ route('user.home.index') . '#pricing' }}" class="px-2 py-1 mt-2 md:mt-0 md:ml-4">
          Pricing
        </a>
        <a href="{{ route('user.home.index') }}" class="px-2 py-1 mt-2 md:mt-0 md:ml-4">
          Blog
        </a>
        @guest
          <a class="px-2 py-1 mt-2 rounded-lg md:mt-0 md:ml-4" href="{{ route('login') }}">
            Login
          </a>
          <a class="px-2 py-1 mt-2 font-medium border-2 rounded-lg border-primary-500 md:mt-0 md:ml-4 text-primary-500"
            href="{{ route('register') }}">
            Sign Up
          </a>
        @endguest
      </nav>
    </div>
  </div>

  <div class="flex flex-col text-gray-500">
    {{ $slot }}
  </div>

  <footer class="bottom-0 px-6 pt-16 pb-8 bg-primary-800">
    <div
      class="grid grid-cols-1 gap-8 pb-10 mx-auto text-gray-300 max-w-7xl md:gap-10 lg:gap-12 md:grid-cols-2 lg:grid-cols-3">
      <div class="flex flex-col col-span-2 space-y-4">
        <h2 class="text-xl font-medium text-white">{{ ucfirst(config('app.name')) }}</h2>
        <p>
          Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum minima id rerum exercitationem harum,
          doloremque amet ea? Similique vitae, magni quam aliquam, repellendus quas delectus illo aliquid nesciunt,
          iusto voluptas.
        </p>

      </div>
      <div class="flex flex-col space-y-4">
        <h2 class="text-xl font-medium text-white">Follow Us</h2>
        <div class="flex space-x-4">
          <a class="flex items-center justify-center w-10 h-10 overflow-hidden bg-white rounded-full" href="#">
            <x-icon.instagram class="w-5 h-5 text-primary-800"></x-icon.instagram>
          </a>
        </div>
      </div>
    </div>
    <div class="font-medium text-center text-gray-300">
      Copyright {{ now()->year }} {{ ucfirst(config('app.name')) }} - All Rights Reserved.
    </div>
  </footer>
  @livewireScripts
  <script src="{{ mix('js/alpine.js') }}"></script>
  @stack('scripts')
</body>

</html>
