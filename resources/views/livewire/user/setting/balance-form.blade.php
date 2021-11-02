<div>
    <x-ui.header class="mb-4 font-semibold border-b border-gray-300">Balances</x-ui.header>
    <x-ui.table>
        <x-slot name="header">
            <x-ui.alt-form wire:submit.prevent="submit">
                <div class="flex flex-col gap-4 lg:items-end lg:flex-row">
                    <x-ui.form-section field="Type" required="true">
                        <x-ui.select wire:model="type" class=" w-52">
                            <option value="deposit">Deposit</option>
                            <option value="withdraw">Withdraw</option>
                        </x-ui.select>
                        @error("type")
                        <x-message.validation type="error">{{ $message }}</x-message.validation>
                        @enderror
                    </x-ui.form-section>
                    <x-ui.form-section field="Amount" required="true">
                        <x-jet-input wire:model="amount" type="number" min="0" class="w-52"/>
                        @error("amount")
                        <x-message.validation type="error">{{ $message }}</x-message.validation>
                        @enderror
                    </x-ui.form-section>
                    <div class="mb-1">
                        <x-jet-button class="h-10" type="submit" wire:loading.attr="disabled">Add
                            <span wire:loading wire:target="submit"
                                class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                            </span>
                        </x-jet-button>
                    </div>
                </div>
            </x-ui.alt-form>
        </x-slot>

        <thead>
            <x-ui.table-row>
                <x-ui.table-header>Type</x-ui.table-header>
                <x-ui.table-header>Amount</x-ui.table-header>
            </x-ui.table-row>
        </thead>
        <tbody>
            @foreach($balances as $balance)
            <x-ui.table-row>
                <x-ui.table-data>{{ ucfirst($balance->type) }}</x-ui.table-data>
                <x-ui.table-data>{{ decimal_to_human($balance->amount, $generals['currency']) }}</x-ui.table-data>
            </x-ui.table-row>
            @endforeach
        </tbody>
    </x-ui.table>
</div>
