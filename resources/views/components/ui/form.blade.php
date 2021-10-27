<form {{ $attributes->merge(['class' => 'flex flex-col justify-between']) }}>
    <div class="p-4 flex flex-col gap-4">
        @if(isset($heading))
        <x-ui.header>{{ $heading }}</x-ui.header>
        @endif

        {{ $slot }}
    </div>

    @if(isset($actions))
    <div class="bg-gray-50 p-4 rounded-b-lg">
        {{ $actions }}
    </div>
    @endif
</form>