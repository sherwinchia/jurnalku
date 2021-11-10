<div>
    <div class="flex justify-end">
        <x-jet-button class="mb-2 " wire:click="showBlankFormModal" wire:loading.attr="disabled" wire:target="showBlankFormModal">Add Portfolio
            <span wire:loading wire:target="showBlankFormModal"
                class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
            </span>
        </x-jet-button>
    </div>
    <div class="grid grid-cols-8 gap-3">
        @foreach($portfolios as $portfolio)
        <x-ui.card class="flex h-40 col-span-8 overflow-hidden border border-gray-200 md:col-span-4 xl:col-span-2">
            <a class="flex-grow " href="{{ route('user.portfolios.show', $portfolio->id) }}">
                <div class="flex flex-col h-full p-3 bg-gray-50">
                    <h3 class="text-sm tracking-widest">{{ $portfolio->name }}</h3>
                    <div class="flex items-end space-x-2 ">
                        <span class="text-lg font-medium tracking-widest">{{ decimal_to_human($portfolio->calculate_balance,$portfolio->currency) }}</span>
                        <div class="flex items-center {{ $portfolio->calculate_growth_percentage != 0 ? ($portfolio->calculate_growth_percentage > 0 ?'text-green-500' : 'text-red-500') : '' }}">
                            <span class="text-sm">{{ decimal_to_human($portfolio->calculate_growth_percentage,null,true) }}</span>
                            @if($portfolio->calculate_growth_percentage>0)
                            <x-icon.chevron-up class="w-4 h-4"/>
                            @elseif($portfolio->calculate_growth_percentage < 0)
                            <x-icon.chevron-down class="w-4 h-4"/>
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-1 mt-auto text-xs">
                        <span>Win</span>
                        <span class="col-span-2"> : {{ decimal_to_human($portfolio->win_percentage,null,true) }}</span>
                        <span>Lose</span>
                        <span class="col-span-2"> : {{ decimal_to_human($portfolio->lose_percentage,null,true) }}</span>
                    </div>
                </div>
            </a>
            <div class="flex flex-col justify-end p-2 space-y-2 text-white bg-primary-500">
                <a class="mx-1 text-lg" role="button" wire:click="showFormModal('{{ $portfolio->id }}')">
                    <x-icon.pencil-alt class="w-4 h-4" />
                </a>
                <a class="mx-1 text-lg" role="button" wire:click="showDeleteModal('{{ $portfolio->id }}')">
                    <x-icon.trash class="w-4 h-4" />
                </a>
            </div>
        </x-ui.card>
        @endforeach
    </div>

    <x-jet-dialog-modal wire:model="deleteModal">
        <x-slot name="title">
            Delete Portfolio
        </x-slot>
        <x-slot name="content">
            This action can not be recovered, all associated data include trades within the portfolio will be removed as well! Make sure to <a class="curspor-pointer text-primary-500" href="{{ route('user.portfolio.export', $portfolio) }}">backup</a> your portfolio first.
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
            {{ $edit ? 'Update' : 'Add' }} Portfolio
        </x-slot>
        <x-slot name="content">
            <x-ui.alt-form wire:submit.prevent="submit">
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
                <x-ui.form-section field="Balance" required="true" class="col-span-4 sm:col-span-2">
                    <x-jet-input wire:model.defer="portfolio.balance" type="number" class="" />
                    @error("portfolio.balance")
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

