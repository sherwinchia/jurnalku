<div x-data class="p-4 border border-gray-300">
  @if (!is_null($old_images) && $old_images->isNotEmpty())
    <h4>Current Images</h4>
    <div class="flex flex-wrap gap-4 mb-4">
      @foreach ($old_images as $index => $image)
        <div
          class="relative flex flex-col flex-wrap w-40 h-40 overflow-hidden bg-white border border-gray-300 rounded-lg group">
          <img class="object-contain w-full h-full overflow-hidden " src="{{ $image->getUrl('thumb') }}" width=""
            alt="">

          {{-- {{ dd($image->getUrl()) }} --}}
          <x-jet-button class="absolute top-0 right-0 z-50 flex justify-center w-8 h-8" type="button"
            wire:loading.attr="disabled" wire:target="removeImage({{ $index }}, true)"
            wire:click.prevent="removeImage({{ $index }}, true)">
            <i class="fas fa-times"></i>
          </x-jet-button>
        </div>
      @endforeach
    </div>
  @endif


  <h4 class="mb-4 ">Selected image(s)</h4>
  @if (!$images)
    <div class="flex flex-col items-center w-full p-4 text-gray-400">
      <i class="mb-4 text-6xl fa fa-file-upload"></i>
      <label>No image selected</label>
    </div>
  @endif
  <div class="flex flex-wrap gap-4">
    @foreach ($images as $index => $image)
      <div
        class="relative flex flex-col flex-wrap w-40 h-40 mb-4 overflow-hidden bg-white border border-gray-300 rounded-lg group">
        <img class="object-contain w-full h-full overflow-hidden " src="{{ $image->temporaryUrl() }}" width="200"
          alt="">
        <label
          class="absolute bottom-0 left-0 invisible p-2 text-xs text-white break-all group-hover:bg-gray-500 group-hover:visible">{{ $image->getClientOriginalName() }}</label>
        <x-jet-button class="absolute top-0 right-0 z-50 flex justify-center w-8 h-8" type="button"
          wire:loading.attr="disabled" wire:target="removeImage({{ $index }})"
          wire:click.prevent="removeImage({{ $index }})">
          <i class="fas fa-times"></i>
        </x-jet-button>
      </div>
    @endforeach
  </div>

  <div class="relative mb-2 border border-gray-500 border-dashed">
    <input type="file" class="relative z-50 w-full h-full p-10 opacity-0 cursor-pointer" wire:model="images"
      {{ $multiple ? 'multiple' : null }} x-on:livewire-upload-finish="$wire.uploadImages()">

    <div class="absolute top-0 bottom-0 left-0 right-0 flex items-center justify-center text-center">
      <span wire:loading wire:target="images"
        class="w-16 h-16 ml-2 border-t-2 border-b-2 border-black rounded-full animate-spin">
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
