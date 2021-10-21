<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta-content')

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> --}}

    <!--Favicon-->
    {{-- <link rel="icon" type='image/x-icon' href="{{ asset('images/brand/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/brand/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/brand/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/brand/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/brand/site.webmanifest') }}"> --}}

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/admin.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/admin.js') }}" defer></script>
</head>

<body class="font-sans antialiased">
    <main class="">
        <div x-data="adminSideBar()" class="flex min-h-screen h-screen" x-init="init()">
            <div class="flex-1 flex overflow-hidden">
                <div x-cloak x-show="sidebarVisible == 'true'" x-transition:enter="transition duration-600"
                    x-transition:enter-start="transform -translate-x-full"
                    x-transition:enter-end="transform -translate-x-0" x-transition:leave="transition duration-600"
                    x-transition:leave-start="transform" x-transition:leave-end="transform -translate-x-full"
                    class="navigation-bar w-64 flex-none overflow-y-auto transform origin-left flex flex-col">
                    <div class=" text-center text-black overflow-hidden h-24 flex items-center justify-center px-2 gap-4">
                         <div class=" font-semibold text-2xl">
                            {{ config('app.name') }}
                        </div> 
                        <x-jet-authentication-card-logo />
                    </div>
                    <div class="overflow-y-auto">
                        <livewire:admin.navbar>
                    </div>

                </div>
                <div class="content flex-1 flex flex-col overflow-y-auto bg-gray-100">
                    <div class="fixed top-0 w-full flex items-center p-6 h-16 bg-white drop-shadow-xl">
                        <div class="text-black text-lg font-roboto font-bold uppercase cursor-pointer mr-4"
                            @click="toggle()">
                            <i class="fas fa-bars text-lg text-black"></i>
                        </div>
                        <div>
                            @yield('breadcrumbs')
                        </div>
                    </div>
                    <div class="pb-16"></div>
                    {{ $slot }}
                </div>
            </div>
        </div>
        <livewire:shared.components.alert />
    </main>
    {{-- @stack('modals') --}}
    {{-- <script type="application/javascript" src="{{ mix('js/admin.js') }}"></script> --}}
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
