<div>
  <x-ui.header class="pb-2 mb-4 border-b border-gray-300 dark:border-gray-600">Free Trial</x-ui.header>
  <x-ui.alt-form wire:submit.prevent="submit">
    <div class="grid grid-cols-4 gap-4">
      <x-ui.form-section field="Active" required="true" class="col-span-4 sm:col-span-2">
        <x-jet-input class="w-6 h-6" wire:model.defer="trialActive" type="checkbox" />
        @error('trialActive')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>
      <x-ui.form-section field="Duration (days)" required="true" class="col-span-4 sm:col-span-2">
        <x-jet-input wire:model.defer="trialDuration" type="number" />
        @error('trialDuration')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>
      <x-ui.form-section field="Max Portfolio" required="true" class="col-span-full">
        <x-jet-input wire:model.defer="maxPortfolio" type="number" />
        @error('maxPortfolio')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>
      <div class="col-span-4">
        <x-jet-button type="submit" wire:loading.attr="disabled" wire:target="submit">
          Update
          <x-ui.loading-indicator wire:target="submit" />
        </x-jet-button>
      </div>
    </div>
  </x-ui.alt-form>
</div>
