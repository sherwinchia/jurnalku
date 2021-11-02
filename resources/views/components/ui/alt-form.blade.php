<form {{ $attributes->merge(['class' => 'flex flex-col justify-between']) }}>
    <div class="flex flex-col gap-2">
        @if(isset($header))
        <x-ui.header>{{ $header }}</x-ui.header>
        @endif

        {{ $slot }}
    </div>

    @if(isset($actions))
    <div class="p-4 rounded-b-lg bg-gray-50">
        {{ $actions }}
    </div>
    @endif
</form>
