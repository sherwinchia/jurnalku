<form {{ $attributes->merge(['class' => 'flex flex-col justify-between']) }}>
    <div class="p-4 flex flex-col gap-2">
        @if(isset($heading))
        <h3 class="block py-3 mb-3 border-b border-gray-300 text-lg font-semibold">{{ $heading }}</h3>
        @endif

        {{ $slot }}
    </div>

    @if(isset($actions))
    <div class="bg-gray-50 p-4 rounded-b-lg">
        {{ $actions }}
    </div>
    @endif
</form>