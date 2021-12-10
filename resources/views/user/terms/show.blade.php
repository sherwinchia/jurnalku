<x-layout.blank>
    <div class="py-4 bg-gray-100">
        <div class="flex flex-col items-center min-h-screen pt-6 sm:pt-0">
            <div>
                <img class="w-12 h-12 lg:w-16 lg:h-16" src="{{ asset('images/logo.png') }}" alt="logo">
            </div>

            <x-ui.card class="flex flex-col w-full p-4 my-4 space-y-3 sm:max-w-4xl">
                <span>Latest Update: {{ $updated_at }}</span>
                <div class="prose">{!! $terms !!}</div>
            </x-ui.card>
        </div>
    </div>
</x-layout.blank>
