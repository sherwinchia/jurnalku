<div>
  <x-ui.header class="pb-2 mb-4 border-b border-gray-300 dark:border-gray-600">Privacy Policy</x-ui.header>
  <x-ui.alt-form x-data="{
        data: null,
        setDefaults(data) {
          let container = document.getElementById('quillEditor');
          quill = new Quill(container, {theme: 'snow', modules:{toolbar:[
              ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
              ['blockquote', 'code-block'],
              [{ 'header': 1 }, { 'header': 2 }],               // custom button values
              [{ 'list': 'ordered'}, { 'list': 'bullet' }],
              [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
              [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
              [{ 'direction': 'rtl' }],                         // text direction
              [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
              [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
              [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
              [{ 'font': [] }],
              [{ 'align': [] }],
              ['clean']   
          ]}});
          quill.root.innerHTML = data;
          let _this = this;
          quill.on('text-change', function() {
            _this.data = quill.root.innerHTML;
          });
        },
        onButtonClick() {
          window.livewire.emit('updateData', this.data);
        }
    }" x-init="setDefaults(`{{ $policyData }}`)">
    <div wire:ignore>
      <div class="mb-2">
        <div class="h-64" id="quillEditor">
        </div>
      </div>
    </div>
    @error('policyData')
      <x-message.validation type="error">{{ $message }}</x-message.validation>
    @enderror
    <div class="">
      <x-jet-button x-on:click.prevent="onButtonClick()" wire:loading.attr="disabled">
        Update
      </x-jet-button>
    </div>
  </x-ui.alt-form>
</div>
