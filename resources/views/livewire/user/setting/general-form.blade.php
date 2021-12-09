<div>
  <x-ui.header class="pb-2 mb-4 border-b border-gray-300 dark:border-gray-600">General</x-ui.header>
  <x-ui.alt-form wire:submit.prevent="submit">

    <x-ui.form-section field="Public Page (Coming Soon)" required="true">
      <x-jet-input wire:model="generals.public_page" type="checkbox" class="w-6 h-6" />
      @error('generals.currency')
        <x-message.validation type="error">{{ $message }}</x-message.validation>
      @enderror
    </x-ui.form-section>

    <div>
      <x-jet-button type="submit" wire:loading.attr="disabled" disabled>Update
        <x-ui.loading-indicator wire:target="submit" />
      </x-jet-button>
    </div>
  </x-ui.alt-form>
</div>
