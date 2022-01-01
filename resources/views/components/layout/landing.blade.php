<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  {{-- <meta name="csrf-token" content="{{ csrf_token() }}" /> --}}
  @yield('meta-content')

  {{-- Fonts --}}

  {{-- Favicon --}}
  <x-meta.favicon />

  {{-- Styles --}}
  <link rel="stylesheet" href="{{ mix('css/user.css') }}" />
  @livewireStyles

  {{-- Scripts --}}
  <script src="{{ mix('js/user.js') }}" defer></script>
</head>

<body class="font-sans antialiased text-gray-700 bg-gray-50 dark:bg-dark-200 dark:text-gray-400">
  <div class="w-full">
    <div x-data="setup()" x-init="init()" x-cloak
      class="flex flex-col px-4 py-4 mx-auto max-w-7xl md:items-center md:justify-between md:flex-row md:px-6 xl:px-0">
      <div class="flex flex-row items-center justify-between">
        <a href="{{ route('user.home.index') }}"
          class="text-lg tracking-widest text-gray-900 uppercase rounded-lg focus:outline-none focus:shadow-outline">
          <img class="w-12 h-12 lg:w-16 lg:h-16" src="{{ asset('images/logo.png') }}" alt="logo" />
        </a>
        <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" x-on:click="open = !open">
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
        class="flex-col items-start flex-grow hidden py-4 space-y-2 text-lg lg:py-0 md:pb-0 md:flex md:justify-end md:flex-row md:items-center md:space-y-0 dark:text-gray-300">
        <button x-on:click="toggleDarkMode()" type="button"
          class="p-2 text-sm rounded-lg md:ml-2 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-3 focus:ring-gray-200 dark:focus:ring-gray-700">
          <x-icon.moon id="theme-toggle-dark-icon" class="w-5 h-5" />
          <x-icon.sun id="theme-toggle-light-icon" class="w-5 h-5 " />
        </button>
        <a href="{{ route('user.home.index') . '#pricing' }}" class="px-2 py-1 mt-2 md:mt-0 md:ml-4">
          Pricing
        </a>
        <a href="{{ route('user.blogs.index') }}" class="px-2 py-1 mt-2 md:mt-0 md:ml-4">
          Blog
        </a>
        @guest
          <a class="px-2 py-1 mt-2 rounded-lg md:mt-0 md:ml-4" href="{{ route('login') }}">
            Login
          </a>
          <a class="px-4 py-2 mt-2 font-medium text-white rounded-lg bg-primary-500 md:mt-0 md:ml-4"
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

  <footer
    class="bottom-0 px-6 py-8 from-primary-800 via-primary-700 to-primary-800 bg-gradient-to-r dark:from-dark-300 dark:to-dark-300">
    <div
      class="grid grid-cols-1 gap-8 pb-10 mx-auto text-gray-200 dark:text-gray-400 max-w-7xl md:gap-10 lg:gap-12 md:grid-cols-2 lg:grid-cols-4">
      <div class="flex flex-col col-span-2 space-y-4">
        <h2 class="text-xl font-medium text-white">
          {{ ucfirst(config('app.name')) }}
        </h2>
        <p>
          Lorem ipsum dolor, sit amet consectetur adipisicing
          elit. Eum minima id rerum exercitationem harum,
          doloremque amet ea? Similique vitae, magni quam aliquam,
          repellendus quas delectus illo aliquid nesciunt, iusto
          voluptas.
        </p>
      </div>
      <div class="flex flex-col col-span-2 space-y-4 lg:col-span-1">
        <h2 class="text-xl font-medium text-white">About</h2>
        <ul class="flex flex-col space-y-1">
          <li><a href="{{ route('user.blogs.index') }}">Blog</a></li>
          <li>
            <a href="{{ route('user.home.index') . '#faq' }}">FAQ</a>
          </li>
          <li>
            <a href="{{ route('user.terms.show') }}">Terms of Service</a>
          </li>
          <li>
            <a href="{{ route('user.policy.show') }}">Privacy Policy</a>
          </li>
        </ul>
      </div>
      <div class="flex flex-col space-y-4">
        <h2 class="text-xl font-medium text-white">Follow Us</h2>
        <div class="flex space-x-4">
          <a class="flex items-center justify-center w-10 h-10 overflow-hidden bg-white rounded-full " href="#">
            <x-icon.instagram class="w-5 h-5 text-primary-800"></x-icon.instagram>
          </a>
        </div>
      </div>
    </div>
    <div class="font-medium text-center text-gray-300 col-span-full">
      Copyright {{ now()->year }} {{ ucfirst(config('app.name')) }} -
      All Rights Reserved.
    </div>
    <p class="text-xs text-center">
      Design and built by Sherwin Variancia
    </p>
  </footer>
  @livewireScripts
  <script src="{{ mix('js/alpine.js') }}"></script>
  @stack('scripts')

  <script type="text/javascript">
    const setup = () => {
      return {
        isDarkMode: false,
        open: false,
        init() {
          if (localStorage.getItem('dark-mode') === null) localStorage.setItem('dark-mode', false);
          this.isDarkMode = localStorage.getItem('dark-mode') === 'true';
          this.toggleHtmlDarkClass();
        },
        toggleDarkMode() {
          this.isDarkMode = !this.isDarkMode;
          localStorage.setItem('dark-mode', this.isDarkMode);

          this.toggleHtmlDarkClass();
        },
        toggleHtmlDarkClass() {
          const html = document.querySelector("html");
          this.isDarkMode ? html.classList.add("dark") : html.classList.remove("dark");

          let themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
          let themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

          if (this.isDarkMode) {
            themeToggleLightIcon.classList.add('hidden');
            themeToggleDarkIcon.classList.remove('hidden');
          } else {
            themeToggleLightIcon.classList.remove('hidden');
            themeToggleDarkIcon.classList.add('hidden');
          }
        }
      }
    }
  </script>
</body>

</html>
