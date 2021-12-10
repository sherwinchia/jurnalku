<div class="flex-1">
  <x-ui.card class="w-full max-w-xl mx-auto" x-data="quillComponent()"
    x-init="setDefaults('{{ data_get($package, 'description') }}')">
    <x-ui.form wire:submit.prevent="submit" heading="{{ $buttonText }} Package" method="POST">
      <x-ui.form-section field="Name" required="true">
        <x-jet-input wire:model.defer="package.name" type="text" />
        @error('package.name')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>
      <x-ui.form-section field="Price" required="true">
        <x-jet-input wire:model.defer="package.price" type="number" />
        @error('package.price')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>
      <x-ui.form-section field="Type" required="true">
        <x-ui.select wire:model.defer="package.type">
          <option value="null" disabled>Choose one type</option>
          <option value="duration">Duration</option>
          <option value="portfolio">Portfolio</option>
        </x-ui.select>
        @error('package.type')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>
      <x-ui.form-section field="Value" required="true">
        <x-jet-input wire:model.defer="package.value" type="number" />
        @error('package.value')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>
      <x-ui.form-section field="Description" required="true">
        {{-- <x-ui.textarea wire:model.defer="package.description" type="text" /> --}}
        <div wire:ignore>
          <div class="mb-2">
            <div class="h-64" id="quillEditor">
            </div>
          </div>
        </div>
        @error('package.description')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>
      <x-ui.form-section field="Active" required="true">
        <x-jet-input wire:model.defer="package.active" type="checkbox" class="w-6 h-6" />
        @error('package.active')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>
      <x-ui.form-section field="Display" required="true">
        <x-jet-input wire:model.defer="package.display" type="checkbox" class="w-6 h-6" />
        @error('package.display')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>

      <x-slot name="actions">
        <x-jet-button x-on:click.prevent="onButtonClick()">{{ $buttonText }}</x-jet-button>
      </x-slot>
    </x-ui.form>
  </x-ui.card>

  <script>
    function quillComponent() {
      return {
        //Data
        data: null,
        //Function
        setDefaults(data) {
          let container = document.getElementById('quillEditor');
          quill = new Quill(container, {
            theme: 'snow'
          });
          quill.root.innerHTML = data;
          let _this = this;
          quill.on('text-change', function() {
            _this.data = quill.root.innerHTML;
          });
        },
        onButtonClick() {
          window.livewire.emit('updateData', this.data);
        }
      }
    }
  </script>
</div>
