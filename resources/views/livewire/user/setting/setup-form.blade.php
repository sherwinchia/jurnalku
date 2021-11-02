<div>
    <x-ui.header class="mb-4 font-semibold border-b border-gray-300 ">Setup</x-ui.header>
    <x-ui.table class="w-full lg:w-96">
        <x-slot name="header">
            <x-ui.alt-form wire:submit.prevent="submit">
                    <x-ui.form-section field="Name" required="true">
                        <x-jet-input wire:model="setup" type="text" min="0" class="w-full lg:w-64"/>
                        @error("setup")
                        <x-message.validation type="error">{{ $message }}</x-message.validation>
                        @enderror
                    </x-ui.form-section>
                    <div class="mb-1">
                        <x-jet-button class="h-10" type="submit" wire:loading.attr="disabled" wire:target="submit">Add
                            <span wire:loading wire:target="submit"
                                class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                            </span>
                        </x-jet-button>
                    </div>

            </x-ui.alt-form>
        </x-slot>

        <thead>
            <x-ui.table-row>
                <x-ui.table-header>Name</x-ui.table-header>
                <x-ui.table-header class="text-center">Action</x-ui.table-header>
            </x-ui.table-row>
        </thead>
        <tbody>
            @foreach($setups as $key => $setup)
            <x-ui.table-row>
                <x-ui.table-data>{{ ucfirst($setup) }}</x-ui.table-data>
                <x-ui.table-data>
                    <a role="button" wire:click="showModal('{{$key}}')">
                        <x-icon.trash class="w-5 h-5 mx-auto" />
                    </a>
                </x-ui.table-data>
            </x-ui.table-row>
            @endforeach
        </tbody>
    </x-ui.table>

    <x-jet-dialog-modal wire:model="modalVisible">
        <x-slot name="title">
            Delete Package
        </x-slot>

        <x-slot name="content">
            This action can not be recovered!
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalVisible')" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled" wire:target="delete">
                Delete
                <span wire:loading wire:target="delete"
                    class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                </span>
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
