<div class="flex-1">
  <x-ui.card class="w-full max-w-4xl mx-auto" x-data="quillComponent()"
    x-init="setDefaults(`{{ data_get($blog, 'body') }}`)">
    <x-ui.form wire:submit.prevent="submit" heading="{{ $buttonText }} Blog" method="POST">
      <div class="grid grid-cols-6 gap-4">
        <x-ui.form-section field="Title" required="true" class="col-span-6 sm:col-span-3">
          <x-jet-input wire:model.defer="blog.title" wire:input="titleAdded" type="text" />
          @error('blog.title')
            <x-message.validation type="error">{{ $message }}</x-message.validation>
          @enderror
        </x-ui.form-section>

        <x-ui.form-section field="Slug" required="true" class="col-span-6 sm:col-span-3">
          <x-jet-input wire:model.defer="blog.slug" type="text" />
          @error('blog.slug')
            <x-message.validation type="error">{{ $message }}</x-message.validation>
          @enderror
        </x-ui.form-section>

        <x-ui.form-section field="Description" required="true" class="col-span-6 sm:col-span-3">
          <x-jet-input wire:model.defer="blog.description" type="text" />
          @error('blog.description')
            <x-message.validation type="error">{{ $message }}</x-message.validation>
          @enderror
        </x-ui.form-section>

        <x-ui.form-section field="Publish Date " required="true" class="col-span-3">
          <x-jet-input wire:model.defer="blog.publish_date" type="datetime-local" />
          @error('blog.publish_date')
            <x-message.validation type="error">{{ $message }}</x-message.validation>
          @enderror
        </x-ui.form-section>

        <x-ui.form-section field="Read Minutes" required="false" class="col-span-3">
          <x-jet-input wire:model.defer="blog.read_minutes" type="text" disabled />
          @error('blog.read_minutes')
            <x-message.validation type="error">{{ $message }}</x-message.validation>
          @enderror
        </x-ui.form-section>

        <x-ui.form-section field="Published" required="true" class="col-span-3">
          <x-jet-input wire:model.defer="blog.published" type="checkbox" class="w-6 h-6" />
          @error('blog.published')
            <x-message.validation type="error">{{ $message }}</x-message.validation>
          @enderror
        </x-ui.form-section>
      </div>

      <x-ui.form-section field="Body" required="true">
        <div wire:ignore>
          <div class="mb-2">
            <div class="h-64" id="quillEditor">
            </div>
          </div>
        </div>
        @error('blog.body')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>

      <x-slot name="actions">
        <x-jet-button type="button" x-on:click="onButtonClick()">{{ $buttonText }}</x-jet-button>
        @if ($edit)
          <a class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition border border-transparent rounded-md bg-primary-500 hover:bg-primary-400 active:bg-primary-600 focus:outline-none focus:border-primary-600 focus:ring focus:ring-primary-300 disabled:opacity-25 dark:text-gray-200"
            href="{{ route('admin.blogs.show', $blog->id) }}">Preview</a>

        @endif
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
            theme: 'snow',
            modules: {
              toolbar: [
                ['bold', 'italic', 'underline', 'strike'], // toggled buttons
                ['blockquote', 'code-block'],
                [{
                  'header': 1
                }, {
                  'header': 2
                }], // custom button values
                [{
                  'list': 'ordered'
                }, {
                  'list': 'bullet'
                }],
                [{
                  'script': 'sub'
                }, {
                  'script': 'super'
                }], // superscript/subscript
                [{
                  'indent': '-1'
                }, {
                  'indent': '+1'
                }], // outdent/indent
                [{
                  'direction': 'rtl'
                }], // text direction
                [{
                  'size': ['small', false, 'large', 'huge']
                }], // custom dropdown
                [{
                  'header': [1, 2, 3, 4, 5, 6, false]
                }],
                [{
                  'color': []
                }, {
                  'background': []
                }], // dropdown with defaults from theme
                [{
                  'font': []
                }],
                [{
                  'align': []
                }],
                ['clean']
              ]
            }
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
