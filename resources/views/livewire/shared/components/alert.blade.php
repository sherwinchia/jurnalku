<div id="live-alert" class="absolute z-50 flex flex-col p-3 overflow-hidden bottom-4 right-4 gap-y-2">
    @foreach ($alerts as $key => $alert)
    <div class="px-2 py-3 bg-white border rounded-lg shadow-md animate__animated animate__slideInRight" role="alert">
        <div class="border-l-4 border-{{ $alert['color'] }} flex items-center gap-4 p-2 max-w-md justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10">
                    @if($alert['type']=='success')
                    <x-icon.check-circle class="w-10 h-10 text-{{ $alert['color'] }} pl-2" />
                    @elseif($alert['type']=='warning')
                    <x-icon.exclamation-circle class="w-10 h-10 text-{{ $alert['color'] }} pl-2" />
                    @elseif($alert['type']=='error')
                    <x-icon.x-circle class="w-10 h-10 text-{{ $alert['color'] }} pl-2" />
                    @endif
                </div>
                <div class="flex flex-col items-left">
                    <span class="text-sm font-semibold">{{ $alert['title'] }}</span>
                    <p class="text-xs ">{{ $alert['message'] }}</p>
                </div>
            </div>
            <x-icon.x wire:click="remove({{ $key }})" class="w-4 h-4 text-gray-400 cursor-pointer"/>
        </div>
    </div>
    @endforeach

    @push('scripts')
    <script>
        const shiftArray = async () => {
            await new Promise(resolve => setTimeout(()=>{
                @this.shift();
            }, 5000));
        }

        Livewire.on('alert-new-alert', () => {
            shiftArray();
        })
    </script>
    @endpush
</div>
