<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @yield('meta-content')

  <title>{{ config('app.name', 'Laravel') }}</title>

  {{-- Fonts --}}

  {{-- Favicon --}}
  <x-meta.favicon />

  {{-- Styles --}}
  <link rel="stylesheet" href="{{ mix('css/user.css') }}">
  @livewireStyles

  {{-- Scripts --}}
  <script src="{{ mix('js/user.js') }}" defer></script>
</head>

<body class="font-sans antialiased" x-data="setup()" x-init="init()" x-cloak>
  <div class="flex flex-col items-center justify-center text-gray-700 bg-gray-100 dark:bg-dark-200 dark:text-gray-400">
    {{ $slot }}
  </div>
  @livewireScripts
  <script src="{{ mix('js/alpine.js') }}"></script>
  @stack('scripts')

  <script type="text/javascript">
    const setup = () => {
      return {
        isDarkMode: false,
        init() {
          if (localStorage.getItem('dark-mode') === null) localStorage.setItem('dark-mode', false);
          this.isDarkMode = localStorage.getItem('dark-mode') === 'true';
          this.toggleHtmlDarkClass();
        },
        toggleHtmlDarkClass() {
          const html = document.querySelector("html");
          this.isDarkMode ? html.classList.add("dark") : html.classList.remove("dark");
        }
      }
    }
  </script>
</body>

</html>
