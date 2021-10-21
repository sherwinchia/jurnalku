<div class="flex-1 flex justify-center overflow-y-hidden">
<div class="card w-full max-w-xl">
    <div class="card-header">
        <p>{{ $buttonText }} Package</p>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="submit" class="flex-none flex flex-col justify-between">
        
        <section>
            <div class="input-group">
                <label for="name">Name <span class="text-red-500">*</span></label>
                <input wire:model.defer="package.name" type="text">
                @error("package.name") <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </section>

        <section>
            <div class="input-group">
                <label for="description">Description <span class="text-red-500">*</span></label>
                <input wire:model.defer="package.description" type="text">
                @error("package.description") <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </section>

        <section>
            <div class="input-group">
                <label for="price">Price <span class="text-red-500">*</span></label>
                <input wire:model.defer="package.price" type="number" min="0">
                @error("package.price") <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </section>
<section>
            <div class="input-group">
                <label for="duration">Duration (Total Days) <span class="text-red-500">*</span></label>
                <input wire:model.defer="package.duration" type="number" min="0">
                @error("package.duration") <span class="error-msg">{{ $message }}</span> @enderror
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