<div {{ $attributes->merge(['class' => 'flex flex-col']) }}>
    @if(isset($header))
    <div class="flex flex-col justify-between gap-2 mb-2 lg:flex-row">
        {{ $header }}
    </div>
    @endif

    <x-ui.card class="flex flex-col py-4 overflow-x-auto ">
        <table class="flex-1">
            {{ $slot }}
        </table>
        @if(isset($footer))
        <div class="flex flex-col justify-between gap-2 px-4 lg:flex-row">
            {{ $footer }}
        </div>
        @endif
    </x-ui.card>
</div>
