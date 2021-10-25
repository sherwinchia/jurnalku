<div {{ $attributes->merge(['class' => 'flex flex-col']) }}>
    @if(isset($header))
    <div class="flex justify-between flex-col lg:flex-row mb-2 gap-2">
        {{ $header }}
    </div>
    @endif

    <x-ui.card class="overflow-x-auto flex flex-col p-4">
        <table class="flex-1">
            {{ $slot }}
        </table>
        @if(isset($footer))
        <div class="flex justify-between flex-col lg:flex-row mb-2 gap-2">
            {{ $footer }}
        </div>
        @endif
    </x-ui.card>
</div>