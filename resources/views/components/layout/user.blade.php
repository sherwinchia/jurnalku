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
            x-transition:enter-end="translate-x-0 opacity-100 ease-out"
            x-transition:leave="transition transform duration-300"
            x-transition:leave-start="translate-x-0 opacity-100 ease-out"
            x-transition:leave-end="-translate-x-full opacity-0 ease-in"
            class="fixed inset-y-0 z-10 flex flex-col flex-shrink-0 w-64 max-h-screen overflow-hidden transition-all transform bg-white border-r shadow-lg lg:z-auto lg:static lg:shadow-none"
            :class="{'-translate-x-full lg:translate-x-0 lg:w-20': !isSidebarOpen}">
            <!-- sidebar header -->
            <div class="flex items-center justify-between p-2" :class="{'lg:justify-center': !isSidebarOpen}">
                <span
                    class="p-2 text-xl font-semibold leading-8 tracking-widest uppercase whitespace-nowrap flex items-center gap-2 text-gray-700">
                    <x-icon.cash class="w-8 h-8 inline-block" /><span :class="{'lg:hidden': !isSidebarOpen}">{{
                        config('app.name')
                        }}</span>
                </span>
                <button @click="toggleSidbarMenu()" class="p-2 rounded-md lg:hidden">
                    <x-icon.x class="h-6 w-6" />
                </button>
            </div>

            <!-- Balance stats -->
            <div class="bg-primary-500 rounded-md m-2 p-3 justify-between items-center text-white"
                :class="{'hidden': !isSidebarOpen, 'lg:flex ': isSidebarOpen}">
                <span class="text-2xl font-semibold">Rp</span>
                <div class="flex flex-col text-right">
                    <span
                        class="font-semibold whitespace-nowrap overflow-ellipsis overflow-hidden inline-block text-2xl">{{
                        decimal_to_human(1900009)
                        }}</span>
                    <span>Balance</span>
                </div>
            </div>

            <!-- Sidebar links -->
            <nav class="flex-1 overflow-hidden hover:overflow-y-auto ">
                <ul class="p-2 overflow-hidden text-lg flex flex-col gap-2">
                    <li>
                        <a href="{{ route('user.home.index') }}"
                        class="flex items-center p-2 space-x-2 rounded-md border border-transparent font-semibold text-xs uppercase tracking-widest hover:bg-primary-400 focus:outline-none active:bg-primary-600 focus:border-primary-600  hover:text-white {{ request()->is('user/home*') ? 'bg-primary-500 text-white' : 'text-gray-700' }}"
                            :class="{'justify-center': !isSidebarOpen}">
                            <x-icon.home class="w-6 h-6" />
                            <span :class="{ 'lg:hidden': !isSidebarOpen }">Home</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('user.journals.index') }}"
                            class="flex items-center p-2 space-x-2 rounded-md border border-transparent font-semibold text-xs uppercase tracking-widest hover:bg-primary-400 focus:outline-none active:bg-primary-600 focus:border-primary-600  hover:text-white {{ request()->is('user/journal*') ? 'bg-primary-500 text-white' : 'text-gray-700' }}"
                            :class="{'justify-center': !isSidebarOpen}">
                            <x-icon.book-open class="h-6 w-6" />
                            <span :class="{ 'lg:hidden': !isSidebarOpen }">Journal</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center p-2 space-x-2 rounded-md border border-transparent font-semibold text-xs uppercase tracking-widest hover:bg-primary-400 focus:outline-none active:bg-primary-600 focus:border-primary-600  hover:text-white {{ request()->is('user/trade-analytics*') ? 'bg-primary-500 text-white' : 'text-gray-700' }}"
                            :class="{'justify-center': !isSidebarOpen}">
                            <span>
                                <x-icon.chart-pie class="w-6 h-6" />
                            </span>
                            <span :class="{ 'lg:hidden': !isSidebarOpen }">Trade Analytics</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center p-2 space-x-2 rounded-md border border-transparent font-semibold text-xs uppercase tracking-widest hover:bg-primary-400 focus:outline-none active:bg-primary-600 focus:border-primary-600  hover:text-white {{ request()->is('user/chart-lab*') ? 'bg-primary-500 text-white' : 'text-gray-700' }}"
                            :class="{'justify-center': !isSidebarOpen}">
                            <span>
                                <x-icon.beaker class="w-6 h-6" />
                            </span>
                            <span :class="{ 'lg:hidden': !isSidebarOpen }">Chart Lab</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center p-2 space-x-2 rounded-md border border-transparent font-semibold text-xs uppercase tracking-widest hover:bg-primary-400 focus:outline-none active:bg-primary-600 focus:border-primary-600  hover:text-white {{ request()->is('user/simulator*') ? 'bg-primary-500 text-white' : 'text-gray-700' }}"
                            :class="{'justify-center': !isSidebarOpen}">
                            <span>
                                <x-icon.desktop-computer class="w-6 h-6" />
                            </span>
                            <span :class="{ 'lg:hidden': !isSidebarOpen }">Simulator</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center p-2 space-x-2 rounded-md border border-transparent font-semibold text-xs uppercase tracking-widest hover:bg-primary-400 focus:outline-none active:bg-primary-600 focus:border-primary-600  hover:text-white {{ request()->is('user/session*') ? 'bg-primary-500 text-white' : 'text-gray-700' }}"
                            :class="{'justify-center': !isSidebarOpen}">
                            <span>
                                <x-icon.cash class="w-6 h-6" />
                            </span>
                            <span :class="{ 'lg:hidden': !isSidebarOpen }">Session</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center p-2 space-x-2 rounded-md border border-transparent font-semibold text-xs uppercase tracking-widest hover:bg-primary-400 focus:outline-none active:bg-primary-600 focus:border-primary-600  hover:text-white {{ request()->is('user/chart-book*') ? 'bg-primary-500 text-white' : 'text-gray-700' }}"
                            :class="{'justify-center': !isSidebarOpen}">
                            <span>
                                <x-icon.chart-square-bar class="w-6 h-6" />
                            </span>
                            <span :class="{ 'lg:hidden': !isSidebarOpen }">Chart Book</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center p-2 space-x-2 rounded-md border border-transparent font-semibold text-xs uppercase tracking-widest hover:bg-primary-400 focus:outline-none active:bg-primary-600 focus:border-primary-600  hover:text-white {{ request()->is('user/notebook*') ? 'bg-primary-500 text-white' : 'text-gray-700' }}"
                            :class="{'justify-center': !isSidebarOpen}">
                            <span>
                                <x-icon.book-open class="w-6 h-6" />
                            </span>
                            <span :class="{ 'lg:hidden': !isSidebarOpen }">Notebook</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center p-2 space-x-2 rounded-md border border-transparent font-semibold text-xs uppercase tracking-widest hover:bg-primary-400 focus:outline-none active:bg-primary-600 focus:border-primary-600  hover:text-white {{ request()->is('user/setting*') ? 'bg-primary-500 text-white' : 'text-gray-700' }}"
                            :class="{'justify-center': !isSidebarOpen}">
                            <span>
                                <x-icon.cog class="w-6 h-6" />
                            </span>
                            <span :class="{ 'lg:hidden': !isSidebarOpen }">Setting</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- Sidebar footer -->
            <div class="flex-shrink-0 p-2 border-t max-h-14">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button onclick="event.preventDefault(); this.closest('form').submit();"
                        class="flex items-center justify-center w-full px-4 py-2 space-x-1 font-medium tracking-wider bg-gray-100 border rounded-md focus:outline-none focus:ring">
                        <span>
                            <x-icon.logout class="h-5 w-5" />
                        </span>
                        <span class="text-xs uppercase tracking-widest" :class="{'lg:hidden': !isSidebarOpen}"> Logout
                        </span>
                    </button>
                </form>

            </div>
        </aside>

        <div class="flex flex-col flex-1 h-full overflow-hidden">
            <!-- Navbar -->
            <header class="flex-shrink-0 border-b text-gray-700">
                <div class="flex items-center justify-between p-2">
                    <!-- Navbar left -->
                    <div class="flex items-center space-x-3">
                        <span class="p-2 text-xl font-semibold tracking-wider uppercase lg:hidden">{{ config('app.name')
                            }}</span>
                        <!-- Toggle sidebar button -->
                        <button @click="toggleSidbarMenu()" class="p-2 rounded-md focus:outline-none focus:ring">
                            <svg class="w-4 h-4 text-gray-600"
                                :class="{'transform transition-transform -rotate-180': isSidebarOpen}"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Navbar right -->
                    <div class="relative flex items-center space-x-3">
                        <!-- Name button-->
                        <div class="relative" x-data="{ isOpen: false }">
                            <button @click="isOpen = !isOpen"
                                class="px-3 py-2 rounded-lg focus:outline-none focus:ring flex items-center gap-2">
                                <span>{{ current_user()->name }}</span>
                                <svg class="w-4 h-4" :class="{'transform transition-transform rotate-180': isOpen}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <!-- Dropdown card -->
                            <div @click.away="isOpen = false" x-show.transition.opacity="isOpen"
                                class="absolute mt-3 transform -translate-x-44 bg-white rounded-md shadow-lg w-64">
                                <div class="flex flex-col p-4 space-y-1 font-medium border-b">
                                    <span class="text-gray-800">{{ current_user()->name }}</span>
                                    <span class="text-sm text-gray-400">{{ current_user()->email }}</span>
                                </div>
                                <ul class="flex flex-col p-2 my-2 space-y-1">
                                    <li>
                                        <a href="{{ route('user.profile.show') }}"
                                            class="block px-2 py-1 transition rounded-md hover:bg-gray-100">Edit
                                            Profile</a>
                                    </li>
                                    <li>
                                        <form class=" px-2 py-1 transition rounded-md hover:bg-gray-100" method="POST"
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
                    </div>
                </div>
            </header>
            <!-- Main content -->
            <main class="flex-1 max-h-full p-5 overflow-hidden overflow-y-auto bg-gray-50">
                <!-- Breadcrumbs -->
                @if(isset($breadcrumbs))
                <div class="mb-4">
                    {{ $breadcrumbs }}
                </div>
                @endif
                <!-- Main content header -->
                @if(isset($header))
                <div
                    class="flex flex-col items-start justify-between pb-4 mb-4 space-y-4 border-b lg:items-center lg:space-y-0 lg:flex-row">
                    <h1 class="text-xl font-semibold whitespace-nowrap">{{ $header }}</h1>
                </div>
                @endif
                <!-- Slot -->
                {{ $slot }}
            </main>
        </div>
    </div>
    <livewire:shared.components.alert />
    @livewireScripts
    <script>
        const setup = () => {
            return {
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