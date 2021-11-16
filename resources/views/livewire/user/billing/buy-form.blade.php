<div class="grid w-full grid-cols-1 gap-10 mx-auto md:grid-cols-2 lg:grid-cols-3">
  @foreach ($packages as $package)
    <div class="flex flex-col items-start p-6 bg-white border rounded-lg shadow-lg">
      <div class="pb-8">
        <h2 class="text-xl font-semibold lg:text-2xl text-primary-500">{{ $package->name }}</h2>
        <p class="text-sm font-normal text-gray-700">{{ $package->description }}</p>
        <span>{{ decimal_to_human($package->price, 'Rp') }}</span>
      </div>
      <x-jet-button wire:click="selectPackage({{ $package->id }})" wire:loading.attr="disabled" class="">
        Select
        <span wire:loading wire:target="selectPackage({{ $package->id }})"
          class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
        </span>
      </x-jet-button>
    </div>
  @endforeach


  <x-jet-dialog-modal wire:model="packageModal">
    <x-slot name="title">
      Billing Summary
    </x-slot>
    <x-slot name="content">
      <x-ui.alt-form>
        <div class="flex flex-col">
          <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-300">
            <div>
              <h2 class="text-xl font-semibold lg:text-2xl text-primary-500">{{ $package->name }}</h2>
              <p class="text-sm font-normal text-gray-700">{{ $package->description }}</p>
            </div>
            <span>{{ decimal_to_human($package->price, 'Rp') }}</span>
          </div>
          <div class="flex justify-between">
            <span>Subtotal</span>
            <span>{{ decimal_to_human($package->price, 'Rp') }}</span>
          </div>
          @if (isset($discount))
            <div class="flex justify-between">
              <span>Discount <span class="text-xs italic">({{ $promocode }})</span></span>
              <span>{{ decimal_to_human($discount, 'Rp') }}</span>
            </div>
          @endif
          <div class="flex justify-between">
            <span>Total</span>
            <span>{{ decimal_to_human($package->price - $discount, 'Rp') }}</span>
          </div>
          <a class="py-2 text-sm italic cursor-pointer" wire:click="$toggle('inputPromocode')">Have promocode?</a>
          @if ($inputPromocode)
            <x-ui.form-section field="Promocode" required="fasle" class="">
              <div class="relative w-1/2">
                <x-jet-input wire:model.defer="promocode" type="text" class="w-full pr-24" />
                <x-jet-button class="absolute inset-y-0 right-0" wire:click="applyCode" wire:loading.attr="disabled">
                  Apply
                  <span wire:loading wire:target="applyCode"
                    class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                  </span>
                </x-jet-button>
              </div>
              @error('promocode')
                <x-message.validation type="error">{{ $message }}</x-message.validation>
              @enderror
            </x-ui.form-section>
          @endif
        </div>
      </x-ui.alt-form>
    </x-slot>
    <x-slot name="footer">
      <x-jet-secondary-button wire:click="$toggle('packageModal')" wire:loading.attr="disabled">
        Cancel
      </x-jet-secondary-button>

      <x-jet-button class="ml-2" wire:click="checkout" wire:loading.attr="disabled">
        Checkout
        <span wire:loading wire:target="checkout"
          class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
        </span>
      </x-jet-button>
    </x-slot>
  </x-jet-dialog-modal>

</div>
