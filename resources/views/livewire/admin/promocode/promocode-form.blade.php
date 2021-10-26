<div class="flex-1">
    <x-ui.card class="w-full max-w-xl mx-auto">
        <x-ui.form wire:submit.prevent="submit" heading="{{ $button_text }} Promocode" method="POST">
            <x-ui.form-section field="Code" required="true">
                <x-jet-input wire:model.defer="promocode.code" type="text" />
                @error("promocode.code")
                <x-message.validation type="error">{{ $message }}</x-message.validation>
                @enderror
            </x-ui.form-section>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <x-ui.form-section field="Type" required="true" class="col-span-2">
                    <x-ui.select wire:model.lazy="promocode.type">
                        <option value="null" disabled>Choose one promotion type</option>
                        <option value="Percentage">Percentage</option>
                        <option value="Fixed">Fixed</option>
                    </x-ui.select>
                    @error("promocode.type")
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                </x-ui.form-section>

                <x-ui.form-section field="{{ $promocode->type == 'Percentage' ? 'Value (%)' : 'Value (Rp)' }}"
                    required="true" class="col-span-2">
                    <x-jet-input wire:model.defer="promocode.value" type="number" />
                    @error("promocode.value")
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                </x-ui.form-section>

                @if($promocode->type == "Percentage")
                <x-ui.form-section field="Max Discount" required="true" class="col-span-2">
                    <x-jet-input wire:model.defer="promocode.max_discount" type="number" />
                    @error("promocode.max_discount")
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                </x-ui.form-section>
                @endif

                <x-ui.form-section field="Use count" required="true" class="col-span-2">
                    <x-ui.select wire:model.lazy="unlimited_use">
                        <option value="null" disabled>Choose one</option>
                        <option value="unlimited">Unlimited</option>
                        <option value="limited">Limited</option>
                    </x-ui.select>
                    @error("promocode.type")
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                </x-ui.form-section>

                @if($unlimited_use == "limited")
                <x-ui.form-section field="Max Use Count " required="true" class="col-span-2">
                    <x-jet-input wire:model.defer="promocode.max_use_count" type="number" />
                    @error("promocode.max_use_count")
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                </x-ui.form-section>
                @endif

                <x-ui.form-section field="Min Spending" required="true" class="col-span-2">
                    <x-jet-input wire:model.defer="promocode.min_spending" type="number" />
                    @error("promocode.min_spending")
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                </x-ui.form-section>

                <x-ui.form-section field="Start" required="true" class="col-span-2">
                    <x-jet-input wire:model.defer="promocode.start_at" type="datetime-local" />
                    @error("promocode.start_at")
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                </x-ui.form-section>

                <x-ui.form-section field="Expired" required="true" class="col-span-2">
                    <x-jet-input wire:model.defer="promocode.expired_at" type="datetime-local" />
                    @error("promocode.expired_at")
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                </x-ui.form-section>

                <div class="col-span-4 grid grid-cols-2 gap-4">
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