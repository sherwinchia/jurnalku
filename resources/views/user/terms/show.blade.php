<x-layout.blank>
    <div class="py-4 bg-gray-100">
        <div class="flex flex-col items-center min-h-screen pt-6 sm:pt-0">
            <div>
                <img class="w-12 h-12 lg:w-16 lg:h-16" src="{{ asset('images/logo.png') }}" alt="logo">
            </div>

            <div class="w-full p-6 mt-6 overflow-hidden prose bg-white shadow-md sm:max-w-2xl sm:rounded-lg">
                {!! $terms !!}
            </div>
        </div>
    </div>
</x-layout.blank>
