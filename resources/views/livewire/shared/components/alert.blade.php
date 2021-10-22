<div id="live-alert" class="absolute bottom-4 right-4 flex-col flex gap-y-2 z-50 p-3 overflow-hidden" >
    @foreach ($alerts as $key => $alert)
        <div class=" bg-white border rounded-lg shadow-md px-2 py-3 animate__animated animate__slideInRight" role="alert">
            <div class="border-l-4 border-{{ $alert['color'] }} flex items-center gap-4 p-2 max-w-md justify-between">
                <div class="flex gap-4 items-center">
                    <i class=" text-2xl fas fa-check-circle text-{{ $alert['color'] }} pl-2"></i>
                    <div class="flex flex-col items-left">
                        <span class="font-semibold text-sm">{{ $alert['title'] }}</span>
                        <p class=" text-xs">{{ $alert['message'] }}</p>
                    </div>
                </div>
                <i wire:click="remove({{ $key }})" class="fas fa-times text-sm text-gray-400 cursor-pointer"></i>
            </div>
        </div>
    @endforeach
</div>