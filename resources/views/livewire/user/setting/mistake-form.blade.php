<div>
    <x-ui.header class="mb-4 font-semibold border-b border-gray-300 ">Mistake</x-ui.header>
    <x-ui.alt-form wire:submit.prevent="submit" class="mb-3">
        <x-ui.form-section field="Name" required="true">
            <div>
                <x-jet-input wire:model="mistake" type="text" min="0" class=""/>
                <x-jet-button class="h-10" type="submit" wire:loading.attr="disabled" wire:target="submit">Add
                    <span wire:loading wire:target="submit"
                        class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                    </span>
                </x-jet-button>
            </div>
        </x-ui.form-section>
        @error("mistake")
        <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
    </x-ui.alt-form>
    <x-ui.alt-table class="w-full overflow-y-auto border lg:w-96 max-h-96">
        <thead>
            <x-ui.table-row>
                <x-ui.table-header>Name</x-ui.table-header>
                <x-ui.table-header class="text-center">Action</x-ui.table-header>
            </x-ui.table-row>
        </thead>
        <tbody>
            @foreach($mistakes as $key => $mistake)
            <x-ui.table-row>
                <x-ui.table-data>{{ ucfirst($mistake) }}</x-ui.table-data>
                <x-ui.table-data>
                    <a role="button" wire:click="showModal('{{$key}}')">
                        <x-icon.trash class="w-5 h-5 mx-auto" />
                    </a>
                </x-ui.table-data>
            </x-ui.table-row>
            @endforeach
        </tbody>
    </x-ui.alt-table>

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
