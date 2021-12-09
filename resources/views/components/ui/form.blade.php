<form {{ $attributes->
    merge(['class' => 'flex flex-col justify-between']) }}>
    <div class="flex flex-col gap-4 p-4">
        @if(isset($heading))
        <x-ui.header>{{ $heading }}</x-ui.header>
        @endif

        {{ $slot }}
    </div>

    @if(isset($actions))
    <div class="p-4 rounded-b-lg bg-gray-50 dark:bg-dark-200">
        {{ $actions }}
    </div>
    @endif
</form>
