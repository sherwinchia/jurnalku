<div>
    <x-ui.header class="mb-4 font-semibold border-b border-gray-300">Portfolio</x-ui.header>
    <x-jet-button class="mb-2" wire:click="showBlankFormModal" wire:loading.attr="disabled" wire:target="showBlankFormModal">Add
        <span wire:loading wire:target="showBlankFormModal"
            class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
        </span>
    </x-jet-button>
    <x-ui.alt-table class="w-full overflow-y-auto border lg:w-96 max-h-96">
        <thead>
            <x-ui.table-row>
                <x-ui.table-header>Name</x-ui.table-header>
                <x-ui.table-header>Currency</x-ui.table-header>
                <x-ui.table-header>Actions</x-ui.table-header>
            </x-ui.table-row>
        </thead>
        <tbody>
            @foreach($portfolios as $portfolio)
            <x-ui.table-row>
                <x-ui.table-data>{{ $portfolio->name }}</x-ui.table-data>
                <x-ui.table-data>{{ $portfolio->currency }}</x-ui.table-data>
                <x-ui.table-data>
                    <div class="flex text-gray-700">
                        <a class="mx-1 text-lg" role="button" wire:click="showFormModal('{{ Crypt::encrypt($portfolio->id) }}')">
                            <x-icon.pencil-alt class="w-5 h-5" />
                        </a>
                        <a class="mx-1 text-lg" role="button" wire:click="showDeleteModal('{{ Crypt::encrypt($portfolio->id) }}')">
                            <x-icon.trash class="w-5 h-5" />
                        </a>
                    </div>
                </x-ui.table-data>
            </x-ui.table-row>
            @endforeach
        </tbody>
    </x-ui.alt-table>

    <x-jet-dialog-modal wire:model="deleteModal">
        <x-slot name="title">
            Delete portfolio
        </x-slot>

        <x-slot name="content">
            This action can not be recovered! All associated trades within a portfolio will be removed as well!
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('deleteModal')" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                Delete
                <span wire:loading wire:target="delete"
                    class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                </span>
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="formModal">
        <x-slot name="title">
            {{ $edit ? 'Update' : 'Add' }} portfolio
        </x-slot>

        <x-slot name="content">
            <x-ui.alt-form>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                <x-ui.form-section field="Name" required="true" class="col-span-4 sm:col-span-2">
                    <x-jet-input wire:model.defer="portfolio.name" type="text" class="" />
                    @error("portfolio.name")
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                </x-ui.form-section>
                <x-ui.form-section field="Currency" required="true" class="col-span-4 sm:col-span-2">
                    <x-jet-input wire:model.defer="portfolio.currency" type="text" class="" />
                    @error("portfolio.currency")
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                </x-ui.form-section>
                </div>
            </x-ui.alt-form>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('formModal')" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="submit" wire:loading.attr="disabled">
                {{ $edit ? 'Update' : 'Add' }}
                <span wire:loading wire:target="submit"
                    class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                </span>
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
