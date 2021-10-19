<div class="flex-1 flex justify-center overflow-y-hidden">
<div class="card w-full max-w-xl">
    <div class="card-header">
        <p>{{ $buttonText }} User</p>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="submit" class="flex-none flex flex-col justify-between">
        <section>
            <div class="input-group">
                <label for="package">Package <span class="text-red-500">*</span></label>
                <input wire:model.defer="package" type="text">
                @error("package") <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </section>
<section>
            <div class="input-group">
                <label for="package">Package <span class="text-red-500">*</span></label>
                <input wire:model.defer="package" type="text">
                @error("package") <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </section>
<section>
            <div class="input-group">
                <label for="package">Package <span class="text-red-500">*</span></label>
                <input wire:model.defer="package" type="text">
                @error("package") <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </section>
<section>
            <div class="input-group">
                <label for="package">Package <span class="text-red-500">*</span></label>
                <input wire:model.defer="package" type="text">
                @error("package") <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </section>
   
            <div>
                <x-jet-button type="button" wire:click.prevent="submit()" wire:loading.attr="disabled" class="">
                    {{ $buttonText }}
                    <span wire:loading wire:target="submit"
                    class="ml-2 animate-spin rounded-full h-3 w-3 border-t-2 border-b-2 border-white">
                    </span>
                </x-jet-button>
            </div>
        </form>
    </div>
    </div>
</div>