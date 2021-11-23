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


  <div class="flex flex-col justify-center items-center bg-gray-100">
    {{ $slot }}
  </div>

  
  @livewireScripts
  <script src="{{ mix('js/alpine.js') }}"></script>
  @stack('scripts')
</body>

</html>
