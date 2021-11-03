<div {{ $attributes->merge(['class' => 'flex flex-col']) }}>
    @if(isset($header))
    <div class="flex flex-col justify-between gap-2 mb-2 lg:flex-row">
        {{ $header }}
    </div>
    @endif

    <div class="flex flex-col">
        <div class="flex-1 overflow-x-auto ">
            <table class="w-full">
                {{ $slot }}
            </table>
        </div>
        @if(isset($footer))
        <div class="flex flex-col justify-between gap-2 px-4 lg:flex-row">
            {{ $footer }}
        </div>
        @endif
    </div>
</div>
