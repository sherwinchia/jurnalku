<div>
  <x-ui.header class="pb-2 mb-4 border-b border-gray-300 dark:border-gray-600">FAQ</x-ui.header>
  <x-ui.alt-form wire:submit.prevent="submit">
    <div class="flex flex-col space-y-4">
      @foreach ($faqData as $index => $data)
        <x-ui.card class="p-4 dark:bg-dark-200">
          <div class="flex justify-between">
            <span>Question No.{{ $index + 1 }}</span>
            <button type="button" class="p-2 rounded-lg" wire:click="delete({{ $index }})">
              <x-icon.x-circle class="w-5 h-5" wire:loading.remove wire:target="delete({{ $index }})" />
              <x-ui.loading-indicator class="m-auto" wire:loading wire:target="delete({{ $index }})" />
            </button>
          </div>
          <x-ui.form-section field="Question" required="true" class="col-span-full">
            <x-jet-input wire:model.defer="faqData.{{ $index }}.question" type="text" />
            @error('faqData.' . $index . '.question')
              <x-message.validation type="error">{{ $message }}</x-message.validation>
            @enderror
          </x-ui.form-section>
          <x-ui.form-section field="Answer" required="true" class="col-span-4 sm:col-span-2">
            <x-ui.textarea wire:model.defer="faqData.{{ $index }}.answer"></x-ui.textarea>
            @error('faqData.' . $index . '.answer')
              <x-message.validation type="error">{{ $message }}</x-message.validation>
            @enderror
          </x-ui.form-section>
        </x-ui.card>
      @endforeach
      <div class="flex col-span-4 space-x-4">
        <x-jet-button type="button" wire:loading.attr="disabled" wire:click="add">
          Add
          <x-ui.loading-indicator wire:target="add" />
        </x-jet-button>
        <x-jet-button type="submit" wire:loading.attr="disabled" wire:target="submit">
          Update
          <x-ui.loading-indicator wire:target="submit" />
        </x-jet-button>
      </div>
    </div>
  </x-ui.alt-form>
</div>
