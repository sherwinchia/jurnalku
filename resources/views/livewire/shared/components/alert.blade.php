<div id="live-alert" class="absolute bottom-4 right-4 flex-col flex gap-y-2 z-50" >
    @foreach ($alerts as $key => $alert)
        @if ($alert["type"] == "success")    
        <div class=" bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded flex items-center gap-2 justify-between alert-item"
            role="alert">
            <div>
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ $alert['message'] }}</span>
            </div>
            <span wire:click="remove({{ $key }})" class="cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </span>
        </div>
        @endif
        @if ($alert["type"] == "error")    
        <div class=" bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded flex items-center gap-2 justify-between alert-item"
            role="alert">
            <div>
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ $alert['message'] }}</span>
            </div>
            <span wire:click="remove({{ $key }})" class="cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </span>
        </div>
        @endif
        @if ($alert["type"] == "warning")    
        <div class=" bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded flex items-center gap-2 justify-between alert-item"
            role="alert">
            <div>
                <strong class="font-bold">Warning!</strong>
                <span class="block sm:inline">{{ $alert['message'] }}</span>
            </div>
            <span wire:click="remove({{ $key }})" class="cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </span>
        </div>
        @endif
        @if ($alert["type"] == "info")    
        <div class=" bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded flex items-center gap-2 justify-between alert-item"
            role="alert">
            <div>
                <strong class="font-bold">Info!</strong>
                <span class="block sm:inline">{{ $alert['message'] }}</span>
            </div>
                <span wire:click="remove({{ $key }})" class="cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </span>
        </div>
        @endif
    @endforeach

    <script>

    </script>

</div>

