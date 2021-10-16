<div x-data class="p-4 border border-gray-300">
    @if (!is_null($old_images) && $old_images->isNotEmpty())
        <h4>Current Images</h4>
        <div class="flex flex-wrap gap-4 mb-4">
            @foreach ($old_images as $index => $image)
                <div
                    class="group w-40 h-40 relative border border-gray-300 rounded-lg flex flex-col flex-wrap overflow-hidden bg-white">
                    <img class=" w-full h-full object-contain overflow-hidden " src="{{ $image->getUrl('thumb') }}"
                        width="" alt="">

                    {{-- {{ dd($image->getUrl()) }} --}}
                    <x-jet-button class="z-50 absolute top-0 right-0 w-8 h-8 flex justify-center" type="button"
                        wire:loading.attr="disabled" wire:target="removeImage({{ $index }}, true)"
                        wire:click.prevent="removeImage({{ $index }}, true)">
                        <i class="fas fa-times"></i>
                    </x-jet-button>
                </div>
            @endforeach
        </div>
    @endif


    <h4 class=" mb-4">Selected image(s)</h4>
    @if (!$images)
        <div class="flex flex-col w-full text-gray-400 p-4 items-center">
            <i class=" text-6xl fa fa-file-upload mb-4"></i>
            <label>No image selected</label>
        </div>
    @endif
    <div class="flex flex-wrap gap-4">
        @foreach ($images as $index => $image)
            <div
                class="group w-40 h-40 relative border border-gray-300 rounded-lg flex flex-col flex-wrap overflow-hidden bg-white mb-4">
                <img class=" w-full h-full object-contain overflow-hidden " src="{{ $image->temporaryUrl() }}"
                    width="200" alt="">
                <label
                    class="break-all absolute bottom-0 left-0 p-2 text-xs invisible group-hover:bg-gray-500 text-white group-hover:visible">{{ $image->getClientOriginalName() }}</label>
                <x-jet-button class="z-50 absolute top-0 right-0 w-8 h-8 flex justify-center" type="button"
                    wire:loading.attr="disabled" wire:target="removeImage({{ $index }})"
                    wire:click.prevent="removeImage({{ $index }})">
                    <i class="fas fa-times"></i>
                </x-jet-button>
            </div>
        @endforeach
    </div>

    <div class="border border-dashed border-gray-500 relative mb-2">
        <input type="file" class="cursor-pointer relative opacity-0 w-full h-full p-10 z-50" wire:model="images"
            {{ $multiple ? 'multiple' : null }} x-on:livewire-upload-finish="$wire.uploadImages()">

        <div class="flex justify-center items-center text-center absolute top-0 bottom-0 left-0 right-0">
            <span wire:loading wire:target="images"
                class="ml-2 animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-black">
            </span>
            <p wire:loading.remove wire:target="images" class="text-gray-400">
                @if ($multiple)
                    Drop files anywhere to upload
                    <br />
                    or <br> Select Files
                @else
                    Drop file anywhere to upload
                    <br />
                    or <br> Select File
                @endif
            </p>
        </div>
    </div>
    @error('images.*') <span class="error-msg">{{ $message }}</span>@enderror
</div>
