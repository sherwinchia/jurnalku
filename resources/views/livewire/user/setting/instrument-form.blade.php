<div>
    <x-ui.header class="pb-2 mb-4 border-b border-gray-300 dark:border-gray-600">Instrument</x-ui.header>
    <x-jet-button class="mb-2" wire:click="showBlankFormModal" wire:loading.attr="disabled" wire:target="showBlankFormModal">Add
        <x-ui.loading-indicator wire:target="showBlankFormModal" />
    </x-jet-button>

    <x-ui.alt-table class="w-full overflow-y-auto border dark:border-gray-600 lg:w-96 max-h-96 ">
        <thead>
            <x-ui.table-row>
                <x-ui.table-header>Name</x-ui.table-header>
                <x-ui.table-header class="text-center">Action</x-ui.table-header>
            </x-ui.table-row>
        </thead>
        <tbody>
            @foreach($instruments as $key => $instrument)
            <x-ui.table-row>
                <x-ui.table-data>{{ ucfirst($instrument) }}</x-ui.table-data>
                <x-ui.table-data>
                    <div class="flex justify-center">
                        <a class="mx-1 text-lg" role="button" wire:click="showFormModal('{{$key}}')">
                            <x-icon.pencil-alt class="w-5 h-5" />
                        </a>
                        <a role="button" wire:click="showDeleteModal('{{$key}}')">
                            <x-icon.trash class="w-5 h-5 mx-auto" />
                        </a>
                    </div>
                </x-ui.table-data>
            </x-ui.table-row>
            @endforeach
        </tbody>
    </x-ui.table>

    <x-jet-dialog-modal wire:model="formModal">
        <x-slot name="title">
            {{ $edit ? 'Update' : 'Add' }} instrument
        </x-slot>

        <x-slot name="content">
            <x-ui.alt-form wire:submit.prevent="submit">
                <x-ui.form-section field="Name" required="true" class="">
                    <x-jet-input wire:model.defer="instrument" type="text" class="" />
                    @error("instrument")
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                </x-ui.form-section>
            </x-ui.alt-form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('formModal')" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="submit" wire:loading.attr="disabled">
                {{ $edit ? 'Update' : 'Add' }}
                <x-ui.loading-indicator wire:target="submit" />
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="deleteModal">
        <x-slot name="title">
            Delete Package
        </x-slot>

        <x-slot name="content">
            This action can not be recovered!
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('deleteModal')" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled" wire:target="delete">
                Delete
                <x-ui.loading-indicator wire:target="delete" />
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
