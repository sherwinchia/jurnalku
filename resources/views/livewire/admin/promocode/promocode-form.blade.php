<div class="flex-1">
    <x-ui.card class="w-full max-w-xl mx-auto">
        <x-ui.form wire:submit.prevent="submit" heading="{{ $button_text }} Promocode" method="POST">
            <x-ui.form-section field="Code" required="true" class="">
                <div class="flex relative">
                    <x-jet-input wire:model.debounce.500ms="promocode.code" wire:input="codeInput" type="text"
                        class="w-full pr-8 sm:pr-32" />
                    <button wire:click.prevent="generateCode"
                        class="absolute right-0 inset-y-0 w-6 sm:w-28 border border-gray-300 rounded-r focus:outline-none overflow-hidden">
                        Random</button>
                </div>
                @error("promocode.code")
                <x-message.validation type="error">{{ $message }}</x-message.validation>
                @enderror
            </x-ui.form-section>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <x-ui.form-section field="Type" required="true" class=" col-span-4 sm:col-span-2">
                    <x-ui.select wire:model.lazy="promocode.type">
                        <option value="null" disabled>Choose type</option>
                        <option value="Percentage">Percentage</option>
                        <option value="Fixed">Fixed</option>
                    </x-ui.select>
                    @error("promocode.type")
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                </x-ui.form-section>

                <x-ui.form-section field="{{ $promocode->type == 'Percentage' ? 'Value (%)' : 'Value (Rp)' }}"
                    required="true" class="col-span-4 sm:col-span-2">
                    <x-jet-input wire:model.defer="promocode.value" type="number" />
                    @error("promocode.value")
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                </x-ui.form-section>

                <x-ui.form-section field="Start" required="true" class="col-span-4 sm:col-span-2">
                    <x-jet-input wire:model.defer="promocode.start_at" type="datetime-local" />
                    @error("promocode.start_at")
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                </x-ui.form-section>

                <x-ui.form-section field="Expired" required="true" class="col-span-4 sm:col-span-2">
                    <x-jet-input wire:model.defer="promocode.expired_at" type="datetime-local" />
                    @error("promocode.expired_at")
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                </x-ui.form-section>

                @if($promocode->type == "Percentage")
                <div class="col-span-4 grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <x-ui.form-section field="Discount Limit" required="true" class="col-span-full sm:col-span-2 ">
                        <x-jet-input wire:model.lazy="discount_limit" type="checkbox" />
                        @error("discount_limit")
                        <x-message.validation type="error">{{ $message }}</x-message.validation>
                        @enderror
                    </x-ui.form-section>

                    @if($promocode->type == "Percentage" && $discount_limit)
                    <x-ui.form-section field="Max Discount" required="true" class="col-span-full sm:col-span-2 ">
                        <x-jet-input wire:model.defer="promocode.max_discount" type="number" />
                        @error("promocode.max_discount")
                        <x-message.validation type="error">{{ $message }}</x-message.validation>
                        @enderror
                    </x-ui.form-section>
                    @endif
                </div>
                @endif

                <div class="col-span-4 grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <x-ui.form-section field="Limited Use" required="false" class="col-span-full sm:col-span-2 ">
                        <x-jet-input wire:model.lazy="limited_use" type="checkbox" />
                        @error("limited_use")
                        <x-message.validation type="error">{{ $message }}</x-message.validation>
                        @enderror
                    </x-ui.form-section>

                    @if($limited_use)
                    <x-ui.form-section field="Max Use Count " required="true" class="col-span-full sm:col-span-2">
                        <x-jet-input wire:model.defer="promocode.max_use_count" type="number" />
                        @error("promocode.max_use_count")
                        <x-message.validation type="error">{{ $message }}</x-message.validation>
                        @enderror
                    </x-ui.form-section>
                    @endif
                </div>

                <div class="col-span-4 grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <x-ui.form-section field="Min Spending" required="false" class="col-span-full sm:col-span-2">
                        <x-jet-input wire:model.lazy="min_spending" type="checkbox" />
                        @error("min_spending")
                        <x-message.validation type="error">{{ $message }}</x-message.validation>
                        @enderror
                    </x-ui.form-section>

                    @if($min_spending)
                    <x-ui.form-section field="Min Spending" required="true" class="col-span-full sm:col-span-2">
                        <x-jet-input wire:model.defer="promocode.min_spending" type="number" />
                        @error("promocode.min_spending")
                        <x-message.validation type="error">{{ $message }}</x-message.validation>
                        @enderror
                    </x-ui.form-section>
                    @endif
                </div>

                <div class="col-span-full grid grid-cols-1 gap-4">
                    <x-ui.form-section field="First Time User" required="false" class="col-span-1">
                        <x-jet-input wire:model.defer="promocode.first_time_user" type="checkbox" />
                        @error("promocode.first_time_user")
                        <x-message.validation type="error">{{ $message }}</x-message.validation>
                        @enderror
                    </x-ui.form-section>

                    <x-ui.form-section field="Active" required="false" class="col-span-1">
                        <x-jet-input wire:model.defer="promocode.active" type="checkbox" />
                        @error("promocode.active")
                        <x-message.validation type="error">{{ $message }}</x-message.validation>
                        @enderror
                    </x-ui.form-section>
                </div>
            </div>

            <x-slot name="actions">
                <x-jet-button type="submit">{{ $button_text }}</x-jet-button>
            </x-slot>
        </x-ui.form>
    </x-ui.card>
</div>