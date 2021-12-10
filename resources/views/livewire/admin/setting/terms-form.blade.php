<div>
  <x-ui.header class="pb-2 mb-4 border-b border-gray-300 dark:border-gray-600">Terms of Service</x-ui.header>
  <x-ui.alt-form x-data="{
        data: null,
        setDefaults(data) {
          let container = document.getElementById('quillEditor');
          quill = new Quill(container, {theme: 'snow'});
            quill.root.innerHTML = data;
          let _this = this;
          quill.on('text-change', function() {
            _this.data = quill.root.innerHTML;
          });
        },
        onButtonClick() {
          window.livewire.emit('updateData', this.data);
        }
  }" x-init="setDefaults(`{{ $termsData }}`)">
    <div wire:ignore>
      <div class="mb-2">
        <div class="h-64" id="quillEditor">
        </div>
      </div>
    </div>
    @error('termsData')
      <x-message.validation type="error">{{ $message }}</x-message.validation>
    @enderror
    <div class="">
      <x-jet-button x-on:click.prevent="onButtonClick()" wire:loading.attr="disabled">
        Update
      </x-jet-button>
    </div>
  </x-ui.alt-form>
</div>
