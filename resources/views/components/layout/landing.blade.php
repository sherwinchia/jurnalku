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
  <div class="fixed inset-x-0 top-0 z-50 w-full bg-white">
    <div x-data="{ open: false }"
      class="flex flex-col px-4 py-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-0 max-w-7xl">
      <div class="flex flex-row items-center justify-between">
        <a href="{{ route('user.home.index') }}"
          class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg focus:outline-none focus:shadow-outline">{{ config('app.name') }}</a>
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
        class="flex-col flex-grow hidden pb-4 md:pb-0 md:flex md:justify-end md:flex-row">
        <a class="px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-gray-200 rounded-lg md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
          href="#">
          Home
        </a>
        <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
          href="#">
          Pricing
        </a>
        <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
          href="#">
          Contact
        </a>
        <div class="pl-4 border-r border-gray-300"></div>
        @guest
          <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
            href="{{ route('login') }}">
            Login
          </a>
          <a class="px-4 py-2 mt-2 text-sm font-semibold text-white bg-transparent border-2 rounded-lg border-primary-500 md:mt-0 md:ml-4 bg-primary-500 focus:outline-none focus:shadow-outline"
            href="#">
            Sign Up
          </a>
        @endguest
        @user
        <a class="px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg md:mt-0 md:ml-4 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
          href="{{ route('user.dashboard.index') }}">
          Dashboard
        </a>
        @enduser
      </nav>
    </div>
  </div>

  <div class="flex flex-col mt-20">
    {{ $slot }}
  </div>
  @livewireScripts
  @stack('scripts')
</body>

</html>
