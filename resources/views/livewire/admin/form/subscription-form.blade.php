<div class="flex-1 flex justify-center overflow-y-hidden">
<div class="card w-full max-w-xl">
    <div class="card-header">
        <p>{{ $buttonText }} Subscription</p>
    </div>
    <div class="card-body">
        <form wire:submit.prevent="submit" class="flex-none flex flex-col justify-between">
        
        <section>
            <div class="input-group">
                <label for="user_id">User Id  <span class="text-red-500">*</span></label>
                <input wire:model.defer="subscription.user_id" type="text">
                @error("subscription.user_id") <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </section>

        <section>
            <div class="input-group">
                <label for="type">Type <span class="text-red-500">*</span></label>
                <input wire:model.defer="subscription.type" type="text">
                @error("subscription.type") <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </section>

        <section>
            <div class="input-group">
                <label for="expired_at">Expired At  <span class="text-red-500">*</span></label>
                <input wire:model.defer="subscription.expired_at" type="text">
                @error("subscription.expired_at") <span class="error-msg">{{ $message }}</span> @enderror
            </div>
        </section>

        <section>
            <div class="input-group">
                <label for="package_id">Package Id  <span class="text-red-500">*</span></label>
                <input wire:model.defer="subscription.package_id" type="text">
                @error("subscription.package_id") <span class="error-msg">{{ $message }}</span> @enderror
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