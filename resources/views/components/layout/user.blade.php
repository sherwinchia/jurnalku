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
  <div class="flex h-screen overflow-y-hidden bg-white" x-data="setup()" x-init="init()" x-cloak>
    <!-- Sidebar backdrop -->
    <div x-show.in.out.opacity="isSidebarOpen" class="fixed inset-0 z-10 bg-black bg-opacity-20 lg:hidden"
      style="backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px)"></div>

    <!-- Sidebar -->
    <aside x-transition:enter="transition transform duration-300"
      x-transition:enter-start="-translate-x-full opacity-30 ease-in"
      x-transition:enter-end="translate-x-0 opacity-100 ease-out" x-transition:leave="transition transform duration-300"
      x-transition:leave-start="translate-x-0 opacity-100 ease-out"
      x-transition:leave-end="-translate-x-full opacity-0 ease-in"
      class="fixed inset-y-0 z-10 flex flex-col flex-shrink-0 w-64 max-h-screen overflow-hidden transition-all transform bg-white border-r shadow-lg lg:z-auto lg:static lg:shadow-none"
      :class="{'-translate-x-full lg:translate-x-0 lg:w-20': !isSidebarOpen}">
      <!-- sidebar header -->
      <div class="flex items-center justify-between p-2" :class="{'lg:justify-center': !isSidebarOpen}">
        <a href="{{ route('user.home.index') }}"
          class="flex items-center gap-2 p-2 text-xl font-semibold leading-8 tracking-widest text-gray-700 uppercase whitespace-nowrap">
          <x-icon.cash class="inline-block w-8 h-8" /><span :class="{'lg:hidden': !isSidebarOpen}"
            class="{'lg:hidden': !isSidebarOpen}">{{ config('app.name') }}</span>
        </a>
        <button @click="toggleSidbarMenu()" class="p-2 rounded-md lg:hidden">
          <x-icon.x class="w-6 h-6" />
        </button>
      </div>

      <!-- Balance stats -->
      {{-- <livewire:user.shared.compact-status /> --}}

      <!-- Sidebar links -->
      <nav class="flex justify-between flex-1 overflow-hidden hover:overflow-y-auto">
        <ul class="flex flex-col w-full h-full gap-2 p-2 overflow-y-auto text-lg">
          <li>
            <x-ui.navbar-link href="{{ route('user.dashboard.index') }}"
              class="{{ request()->is('user/home*') ? 'bg-gray-50 text-primary-500 border-l-4' : 'text-gray-700' }}"
              x-bind:class="{'justify-center': !isSidebarOpen}">
              <x-icon.home class="w-6 h-6" />
              <span :class="{ 'lg:hidden': !isSidebarOpen }">Dashboard</span>
            </x-ui.navbar-link>
          </li>
          <li>
            <x-ui.navbar-link href="{{ route('user.portfolios.index') }}"
              class="{{ request()->is('user/portfolio*') || request()->is('user/trade*') ? 'bg-gray-50 text-primary-500 border-l-4' : 'text-gray-700' }}"
              x-bind:class="{'justify-center': !isSidebarOpen}">
              <x-icon.book-open class="w-6 h-6" />
              <span :class="{ 'lg:hidden': !isSidebarOpen }">Portfolio</span>
            </x-ui.navbar-link>
          </li>
          <li>
            <x-ui.navbar-link href="#"
              class="{{ request()->is('user/trade-analytics*') ? 'bg-gray-50 text-primary-500 border-l-4' : 'text-gray-700' }}"
              x-bind:class="{'justify-center': !isSidebarOpen}">
              <x-icon.chart-pie class="w-6 h-6" />
              <span :class="{ 'lg:hidden': !isSidebarOpen }">Analytics</span>
            </x-ui.navbar-link>
          </li>
          <li>
            <x-ui.navbar-link href="{{ route('user.settings.index') }}"
              class="{{ request()->is('user/settings*') ? 'bg-gray-50 text-primary-500 border-l-4' : 'text-gray-700' }}"
              x-bind:class="{'justify-center': !isSidebarOpen}">
              <x-icon.cog class="w-6 h-6" />
              <span :class="{ 'lg:hidden': !isSidebarOpen }">Settings</span>
            </x-ui.navbar-link>
          </li>
          <li class="mt-auto">
            <x-ui.navbar-link href=" {{ route('user.billings.index') }}"
              class="{{ request()->is('user/billing*') ? 'bg-gray-50 text-primary-500 border-l-4' : 'text-gray-700' }}"
              x-bind:class="{'justify-center': !isSidebarOpen}">
              <x-icon.credit-card class="w-6 h-6" />
              <span :class="{ 'lg:hidden': !isSidebarOpen }">Billings</span>
            </x-ui.navbar-link>
          </li>
          <li class="">
            <x-ui.navbar-link href=" {{ route('user.profile.show') }}"
              class="{{ request()->is('user/profile*') ? 'bg-gray-50 text-primary-500 border-l-4' : 'text-gray-700' }}"
              x-bind:class="{'justify-center': !isSidebarOpen}">
              <x-icon.user class="w-6 h-6" />
              <span :class="{ 'lg:hidden': !isSidebarOpen }">Profile</span>
            </x-ui.navbar-link>

        </ul>
      </nav>
      <!-- Sidebar footer -->

      <div class="flex-shrink-0 p-2 border-t max-h-14">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button onclick="event.preventDefault(); this.closest('form').submit();"
            class="flex items-center justify-center w-full px-4 py-2 space-x-1 font-medium tracking-wider bg-gray-100 border rounded-md focus:outline-none focus:ring">
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
      <header class="flex-shrink-0 text-gray-700 border-b">
        <div class="flex items-center justify-between p-2">
          <!-- Navbar left -->
          <div class="flex items-center space-x-3">
            <span class="p-2 text-xl font-semibold tracking-wider uppercase lg:hidden"
              class="p-2 text-xl font-semibold tracking-wider uppercase lg:hidden"> {{ config('app.name') }}</span>
            <!-- Toggle sidebar button -->
            <button @click="toggleSidbarMenu()" class="p-2 rounded-md focus:outline-none focus:ring">
              <svg class="w-4 h-4 text-gray-600" :class="{'transform transition-transform -rotate-180': isSidebarOpen}"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
              </svg>
            </button>
          </div>

          <!-- Navbar right -->
          {{-- <div class="relative flex items-center space-x-3">
            <!-- Name button-->
            <div class="relative" x-data="{ isOpen: false }">
              <button @click="isOpen = !isOpen"
                class="flex items-center gap-2 px-3 py-2 rounded-lg focus:outline-none focus:ring">
                <span>{{ current_user()->name }}</span>
                <svg class="w-4 h-4" :class="{'transform transition-transform rotate-180': isOpen}" fill="none"
                  stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
              </button>

              <!-- Dropdown card -->
              <div @click.away="isOpen = false" x-show.transition.opacity="isOpen"
                class="absolute w-64 mt-3 transform bg-white rounded-md shadow-lg -translate-x-44">
                <div class="flex flex-col p-4 space-y-1 font-medium border-b">
                  <span class="text-gray-800">{{ current_user()->name }}</span>
                  <span class="text-sm text-gray-400">{{ current_user()->email }}</span>
                </div>
                <ul class="flex flex-col p-2 my-2 space-y-1">
                  <li>
                    <a href="{{ route('user.transactions.index') }}"
                      class="block px-2 py-1 transition rounded-md hover:bg-gray-100">Purchase
                      History</a>
                  </li>
                  <li>
                    <a href="{{ route('user.profile.show') }}"
                      class="block px-2 py-1 transition rounded-md hover:bg-gray-100">Edit
                      Profile</a>
                  </li>
                  <li>
                    <form class="px-2 py-1 transition rounded-md hover:bg-gray-100" method="POST"
                      action="{{ route('logout') }}">
                      @csrf
                      <button class="w-full text-left focus:outline-none" onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                        {{ __('Logout') }}
                      </button>
                    </form>
                  </li>
                </ul>

              </div>
            </div>
          </div> --}}
        </div>
      </header>
      <!-- Main content -->
      <main class="flex-1 max-h-full p-3 overflow-hidden overflow-y-auto bg-gray-50">
        <!-- Breadcrumbs -->
        @if (isset($breadcrumbs))
          <div class="mb-4">
            {{ $breadcrumbs }}
          </div>
        @endif
        <!-- Main content header -->
        @if (isset($header))
          <div
            class="flex flex-col items-start justify-between pb-4 mb-4 space-y-4 border-b lg:items-center lg:space-y-0 lg:flex-row">
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
  @stack('scripts')
  <script>
    const setup = () => {
      return {
        authenticationDrop: false,
        isSidebarOpen: false,
        init() {
          if (localStorage.getItem('sidebar') === null) localStorage.setItem('sidebar', true);
          this.isSidebarOpen = localStorage.getItem('sidebar') === 'true';
        },
        toggleSidbarMenu() {
          this.isSidebarOpen = !this.isSidebarOpen;
          localStorage.setItem('sidebar', this.isSidebarOpen);
        },
      }
    }
  </script>
</body>

</html>
