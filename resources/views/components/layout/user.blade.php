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
  {{-- <link rel="icon" type='image/x-icon' href="{{ asset('images/brand/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/brand/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/brand/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/brand/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/brand/site.webmanifest') }}"> --}}

  <!-- Styles -->
  <link rel="stylesheet" href="{{ mix('css/user.css') }}">
  @livewireStyles

  <!-- Scripts -->
  <script src="{{ asset('js/chartjs.js') }}"></script>
  <script src="{{ mix('js/user.js') }}"></script>
</head>

<body class="font-sans antialiased">
  <div class="flex h-screen overflow-y-hidden text-gray-700 bg-white dark:bg-dark-200 dark:text-gray-400"
    x-data="setup()" x-init="init()" x-cloak>
    <!-- Sidebar backdrop -->
    <div x-show.in.out.opacity="isSidebarOpen" class="fixed inset-0 z-10 bg-black bg-opacity-20 lg:hidden"
      style="backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px)"></div>

    <!-- Sidebar -->
    <aside x-transition:enter="transition transform duration-300"
      x-transition:enter-start="-translate-x-full opacity-30 ease-in"
      x-transition:enter-end="translate-x-0 opacity-100 ease-out" x-transition:leave="transition transform duration-300"
      x-transition:leave-start="translate-x-0 opacity-100 ease-out"
      x-transition:leave-end="-translate-x-full opacity-0 ease-in"
      class="fixed inset-y-0 z-10 flex flex-col flex-shrink-0 w-64 max-h-screen overflow-hidden transition-all transform bg-white border-r shadow-lg dark:border-gray-600 dark:bg-dark-200 lg:z-auto lg:static lg:shadow-none"
      :class="{'-translate-x-full lg:translate-x-0 lg:w-20': !isSidebarOpen}">
      <!-- sidebar header -->
      <div class="flex items-center justify-between p-2" :class="{'lg:justify-center': !isSidebarOpen}">
        <a href="{{ route('user.home.index') }}"
          class="flex items-center gap-2 p-2 text-xl font-semibold leading-8 tracking-widest text-gray-700 uppercase dark:gray-500 whitespace-nowrap">
          <img class="w-8 h-8 lg:w-10 lg:h-10" src="{{ asset('images/logo.png') }}" alt="logo">
          <span :class="{'lg:hidden': !isSidebarOpen}" class="{'lg:hidden': !isSidebarOpen}">{{ config('app.name') }}
          </span>
        </a>
        <button x-on:click="toggleSidbarMenu()" class="p-2 rounded-md lg:hidden">
          <x-icon.x class="w-6 h-6" />
        </button>
      </div>

      <!-- Sidebar links -->
      <nav class="flex justify-between flex-1 overflow-hidden hover:overflow-y-auto">
        <ul class="flex flex-col w-full h-full gap-2 p-2 overflow-y-auto text-lg">
          <li>
            <x-ui.navbar-link href="{{ route('user.dashboard.index') }}"
              class="{{ request()->is('user') ? 'bg-gray-50 dark:bg-dark-100 text-primary-500 border-l-4' : '' }}"
              x-bind:class="{'justify-center': !isSidebarOpen}">
              <x-icon.home class="w-6 h-6" />
              <span :class="{ 'lg:hidden': !isSidebarOpen }">Dashboard</span>
            </x-ui.navbar-link>
          </li>
          <li>
            <x-ui.navbar-link href="{{ route('user.portfolios.index') }}"
              class="{{ request()->is('user/portfolio*') || request()->is('user/trade*') ? 'bg-gray-50 dark:bg-dark-100 text-primary-500 border-l-4' : '' }}"
              x-bind:class="{'justify-center': !isSidebarOpen}">
              <x-icon.book-open class="w-6 h-6" />
              <span :class="{ 'lg:hidden': !isSidebarOpen }">Portfolio</span>
            </x-ui.navbar-link>
          </li>
          {{-- <li>
            <x-ui.navbar-link href="{{ route('user.analytics.index') }}"
              class="{{ request()->is('user/analytics*') ? 'bg-gray-50 dark:bg-dark-100 text-primary-500 border-l-4' : '' }}"
              x-bind:class="{'justify-center': !isSidebarOpen}">
              <x-icon.chart-pie class="w-6 h-6" />
              <span :class="{ 'lg:hidden': !isSidebarOpen }">Analytics</span>
            </x-ui.navbar-link>
          </li> --}}
          <li>
            <x-ui.navbar-link href="{{ route('user.settings.index') }}"
              class="{{ request()->is('user/settings*') ? 'bg-gray-50 dark:bg-dark-100 text-primary-500 border-l-4' : '' }}"
              x-bind:class="{'justify-center': !isSidebarOpen}">
              <x-icon.cog class="w-6 h-6" />
              <span :class="{ 'lg:hidden': !isSidebarOpen }">Settings</span>
            </x-ui.navbar-link>
          </li>
          <li class="mt-auto">
            <x-ui.navbar-link href=" {{ route('user.billings.index') }}"
              class="{{ request()->is('user/billing*') ? 'bg-gray-50 dark:bg-dark-100 text-primary-500 border-l-4' : '' }}"
              x-bind:class="{'justify-center': !isSidebarOpen}">
              <x-icon.credit-card class="w-6 h-6" />
              <span :class="{ 'lg:hidden': !isSidebarOpen }">Billings</span>
            </x-ui.navbar-link>
          </li>
          <li class="">
            <x-ui.navbar-link href=" {{ route('user.profile.show') }}"
              class="{{ request()->is('user/profile*') ? 'bg-gray-50 dark:bg-dark-100 text-primary-500 border-l-4' : '' }}"
              x-bind:class="{'justify-center': !isSidebarOpen}">
              <x-icon.user class="w-6 h-6" />
              <span :class="{ 'lg:hidden': !isSidebarOpen }">Profile</span>
            </x-ui.navbar-link>
          </li>

        </ul>
      </nav>
      <!-- Sidebar footer -->
      <div class="flex-shrink-0 p-2 border-t dark:border-gray-600 max-h-14">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button onclick="event.preventDefault(); this.closest('form').submit();"
            class="flex items-center justify-center w-full px-4 py-2 space-x-1 font-medium tracking-wider bg-gray-100 border rounded-md dark:bg-dark-100 dark:border-transparent focus:outline-none focus:ring">
            <span>
              <x-icon.logout class="w-5 h-5" />
            </span>
            <span class="text-xs tracking-widest uppercase" :class="{'lg:hidden': !isSidebarOpen}"> Logout
            </span>
          </button>
        </form>

      </div>
    </aside>

    <div class="flex flex-col flex-1 h-full overflow-hidden">
      <!-- Navbar -->
      <header class="flex-shrink-0 border-b dark:border-gray-600 ">
        <div class="flex items-center justify-between p-2">
          <!-- Navbar left -->
          <div class="flex items-center space-x-3">
            {{-- <span class="p-2 text-xl font-semibold tracking-wider uppercase lg:hidden"
              class="p-2 text-xl font-semibold tracking-wider uppercase lg:hidden"> {{ config('app.name') }}</span> --}}
            <!-- Toggle sidebar button -->
            <button x-on:click="toggleSidbarMenu()" class="p-2 rounded-md focus:outline-none focus:ring">
              <svg class="w-4 h-4 " :class="{'transform transition-transform -rotate-180': isSidebarOpen}"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
              </svg>
            </button>
          </div>
          <span class="">{{ date_to_human(now(), 'd F Y') }}</span>
          <button x-on:click="toggleDarkMode()" type="button"
            class=" dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
            <svg id="theme-toggle-dark-icon" class="w-5 h-5 " fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
            <svg id="theme-toggle-light-icon" class="w-5 h-5 " fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path
                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                fill-rule="evenodd" clip-rule="evenodd"></path>
            </svg>
          </button>
        </div>
      </header>
      <!-- Main content -->
      <main class="flex-1 max-h-full p-3 overflow-hidden overflow-y-auto bg-gray-50 dark:bg-dark-200">
        <!-- Breadcrumbs -->
        @if (isset($breadcrumbs))
          <div class="mb-4">
            {{ $breadcrumbs }}
          </div>
        @endif
        <!-- Main content header -->
        @if (isset($header))
          <div
            class="flex flex-col items-start justify-between pb-4 mb-4 space-y-4 border-b dark:border-gray-600 lg:items-center lg:space-y-0 lg:flex-row">
            <h1 class="text-lg font-medium whitespace-nowrap">{{ $header }}</h1>
          </div>
        @endif
        <!-- Slot -->
        {{ $slot }}
      </main>
    </div>

  </div>
  <livewire:shared.components.alert />
  @livewireScripts
  <script type="text/javascript" src="{{ mix('js/alpine.js') }}"></script>
  @stack('scripts')
  <script>
    const setup = () => {
      return {
        authenticationDrop: false,
        isSidebarOpen: false,
        isDarkMode: false,
        init() {
          if (localStorage.getItem('sidebar') === null) localStorage.setItem('sidebar', true);
          this.isSidebarOpen = localStorage.getItem('sidebar') === 'true';

          if (localStorage.getItem('dark-mode') === null) localStorage.setItem('dark-mode', false);
          this.isDarkMode = localStorage.getItem('dark-mode') === 'true';
          this.toggleHtmlDarkClass();
        },
        toggleSidbarMenu() {
          this.isSidebarOpen = !this.isSidebarOpen;
          localStorage.setItem('sidebar', this.isSidebarOpen);
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

          // Change the icons inside the button based on previous settings
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
