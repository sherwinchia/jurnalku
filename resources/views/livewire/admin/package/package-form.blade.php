<div class="flex-1">
    <x-ui.card class="w-full max-w-xl mx-auto">
        <x-ui.form wire:submit.prevent="submit" heading="{{ $buttonText }} Package">
            <x-ui.form-section field="Name" required="true">
                <x-jet-input wire:model.defer="package.name" type="text" />
                @error('package.name')
                <x-message.validation type="error">{{ $message }}</x-message.validation>
                @enderror
            </x-ui.form-section>
            <x-ui.form-section field="Price" required="true">
                <x-jet-input wire:model.defer="package.price" type="number" />
                @error('package.price')
                <x-message.validation type="error">{{ $message }}</x-message.validation>
                @enderror
            </x-ui.form-section>
            <x-ui.form-section field="Duration" required="true">
                <x-jet-input wire:model.defer="package.duration" type="number" />
                @error('package.duration')
                <x-message.validation type="error">{{ $message }}</x-message.validation>
                @enderror
            </x-ui.form-section>
            <x-ui.form-section field="Description" required="true">
                <x-ui.textarea wire:model.defer="package.description" type="text" />
                @error('package.description')
                <x-message.validation type="error">{{ $message }}</x-message.validation>
                @enderror
            </x-ui.form-section>
            <x-ui.form-section field="Active" required="true">
                <x-jet-input wire:model.defer="package.active" type="checkbox" class="w-6 h-6" />
                @error('package.active')
                <x-message.validation type="error">{{ $message }}</x-message.validation>
                @enderror
            </x-ui.form-section>

            <x-slot name="actions">
                <x-jet-button wire:click="submit">{{ $buttonText }}</x-jet-button>
            </x-slot>
        </x-ui.form>
    </x-ui.card>
</div>