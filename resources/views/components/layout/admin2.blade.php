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
    <link rel="stylesheet" href="{{ mix('css/admin.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/admin.js') }}" defer></script>
</head>

<body class="font-sans antialiased">
    <main class="">
        <div x-data="adminSideBar()" class="flex min-h-screen h-screen" x-init="init()">
            <div class="flex-1 flex">
                <div x-cloak x-show="sidebarVisible == 'true'" x-transition:enter="transition transform duration-300"
                    x-transition:enter-start="-translate-x-full opacity-30  ease-in"
                    x-transition:enter-end="translate-x-0 opacity-100 ease-out"
                    x-transition:leave="transition transform duration-300"
                    x-transition:leave-start="translate-x-0 opacity-100 ease-out"
                    x-transition:leave-end="-translate-x-full opacity-0 ease-in"
                    class="navigation-bar w-64 flex-none overflow-y-auto transform origin-left flex flex-col">
                    <div
                        class=" text-center text-black overflow-hidden h-24 flex items-center justify-center px-2 gap-4">
                        <div class=" font-semibold text-2xl">
                            {{ config('app.name') }}
                        </div>
                        <x-jet-authentication-card-logo />
                    </div>
                    <div class="overflow-y-auto">
                        <livewire:admin.shared.navbar>
                    </div>
                </div>
                <div class=" flex-1 flex flex-col bg-gray-100">
                    <div class="w-full flex justify-between items-center p-6 h-16 bg-white drop-shadow-xl z-50">
                        <div class="text-black text-lg font-roboto font-bold uppercase cursor-pointer mr-4"
                            @click="toggle()">
                            <i class="fas fa-bars text-lg text-black"></i>
                        </div>
                        <x-jet-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        {{ Auth::user()->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>

                                <x-jet-dropdown-link href="{{ route('admin.profile.show') }}">
                                    {{ __('Profile') }}
                                </x-jet-dropdown-link>

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-jet-dropdown-link>
                                @endif

                                <div class="border-t border-gray-100"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-jet-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-jet-dropdown-link>
                                </form>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                    <div class="overflow-y-auto">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
        <livewire:shared.components.alert />
    </main>
    @livewireScripts
    @yield('scripts')
    <script>
        function adminSideBar() {
            return {
                sidebarVisible: null,
                init() {
                    if (localStorage.getItem('sidebar') == null) localStorage.setItem('sidebar', true);
                    this.sidebarVisible = localStorage.getItem('sidebar');
                },
                toggle() {
                    localStorage.getItem('sidebar') === 'true' ? localStorage.setItem('sidebar', false) : localStorage
                        .setItem('sidebar', true);
                    this.sidebarVisible = localStorage.getItem('sidebar');
                }
            }
        }

    </script>
</body>

</html>