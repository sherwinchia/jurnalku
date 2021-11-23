<div>
  <x-ui.header class="pb-2 font-medium">Select Package</x-ui.header>
  @if ($packages->isEmpty())
    <p class="pb-2">No package available</p>
  @endif
  <div class="grid w-full grid-cols-1 gap-10 mx-auto md:grid-cols-2 lg:grid-cols-3" wire:init="getPaymentMethods">
    @foreach ($packages as $package)
      <div class="flex flex-col items-start col-span-1 p-6 bg-white border rounded-lg shadow-lg">
        <div class="pb-8 ">
          <h2 class="text-xl font-semibold lg:text-2xl text-primary-500">{{ $package->name }}</h2>
          <p class="text-sm font-normal text-gray-700">{{ $package->description }}</p>
          <span>{{ decimal_to_human($package->price, 'Rp') }}</span>
        </div>
        <x-jet-button wire:click="selectPackage({{ $package->id }})" wire:loading.attr="disabled"
          class="">
          Select
          <span wire:loading wire:target="selectPackage({{ $package->id }})"
            class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
          </span>
        </x-jet-button>
      </div>
    @endforeach
  </div>
  <x-jet-dialog-modal wire:model="packageModal">
    <x-slot name="title">
      Billing Summary
    </x-slot>
    <x-slot name="content">
      @if (isset($selectedPackage))
        <x-ui.alt-form class="pb-2">
          <div class="flex flex-col">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-200">
              <div>
                <h2 class="font-medium">{{ $selectedPackage->name }}</h2>
                <p class="text-sm font-normal text-gray-700">{{ $selectedPackage->description }}</p>
              </div>
              <span>{{ decimal_to_human($selectedPackage->price, 'Rp') }}</span>
            </div>
            @if (isset($temporaryDiscount))
              <div class="flex justify-between">
                <span class="text-sm">Subtotal</span>
                <span>{{ decimal_to_human($selectedPackage->price, 'Rp') }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-sm">Discount <span class="text-xs italic">({{ $code }})</span></span>
                <span>{{ decimal_to_human($temporaryDiscount, 'Rp') }}</span>
              </div>
            @endif
            <div class="flex justify-between font-medium">
              <span class="text-sm">Total</span>

              <span>{{ decimal_to_human($temporaryTotal) }}</span>
            </div>
            <a class="py-2 text-sm italic cursor-pointer" wire:click="$toggle('inputPromocode')">Enter promocode</a>
            @if ($inputPromocode)
              <x-ui.form-section field="Promocode" required="fasle" class="">
                <div class="relative w-full lg:w-1/2">
                  <x-jet-input wire:model.devounce.500ms="code" wire:input="promoCodeInput" type="text"
                    class="w-full pr-24" />
                  <x-jet-button class="absolute inset-y-0 right-0" wire:click="applyCode" wire:loading.attr="disabled">
                    Apply
                    <span wire:loading wire:target="applyCode"
                      class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                    </span>
                  </x-jet-button>
                </div>
                @error('code')
                  <x-message.validation type="error">{{ $message }}</x-message.validation>
                @enderror
              </x-ui.form-section>
            @endif
          </div>
        </x-ui.alt-form>

        @if (isset($temporaryTotal) && $temporaryTotal > 0)
          <h2 class="pb-2 font-medium lg:text-lg">
            Payment Methods
          </h2>
          <div class="flex flex-wrap gap-2 pb-2">
            <span wire:loading wire:target="getPaymentMethods"
              class="w-10 h-10 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
            </span>
            @foreach ($paymentMethods as $method)
              <a class="px-3 flex flex-col w-24 lg:w-36 py-2 border rounded-lg cursor-pointer space-y-2 {{ $selectedPaymentMethod == $method['code'] ? 'border-primary-500' : '' }}"
                wire:click="selectPaymentMethod('{{ $method['code'] }}')">
                <img class="object-cover" src="{{ asset('images/development-icon.png') }}" alt="">
                <span class="text-sm">
                  {{ $method['name'] }}
                </span>
              </a>
            @endforeach
          </div>
          @error('selectedPaymentMethod')
            <x-message.validation type="error">{{ $message }}</x-message.validation>
          @enderror
        @endif
      @endif
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
