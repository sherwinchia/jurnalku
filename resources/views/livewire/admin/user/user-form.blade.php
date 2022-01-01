<div class="flex-1">
  <x-ui.card class="w-full max-w-xl mx-auto">
    <x-ui.form wire:submit.prevent="submit" heading="{{ $buttonText }} user" method="POST">
      <x-ui.form-section field="Name" required="true">
        <x-jet-input wire:model.defer="user.name" type="text" />
        @error('user.name')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>

      <x-ui.form-section field="Slug" required="true">
        <x-jet-input wire:model.defer="user.slug" type="text" />
        @error('user.slug')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>

      @if ($edit)
        <x-ui.form-section field="Email" required="true">
          <x-jet-input wire:model.defer="user.email" type="email" disabled />
          @error('user.email')
            <x-message.validation type="error">{{ $message }}</x-message.validation>
          @enderror
        </x-ui.form-section>
      @else
        <x-ui.form-section field="Email" required="true">
          <x-jet-input wire:model.defer="user.email" type="email" />
          @error('user.email')
            <x-message.validation type="error">{{ $message }}</x-message.validation>
          @enderror
        </x-ui.form-section>
      @endif

      <x-ui.form-section field="Role" required="true">
        <x-ui.select wire:model.defer="user.role_id">
          <option value="null" disabled>Choose one role</option>
          @foreach ($roles as $role)
            <option value="{{ $role->id }}">{{ $role->name }}</option>
          @endforeach
        </x-ui.select>
        @error('user.role_id') <span class="error-msg">{{ $message }}</span> @enderror
      </x-ui.form-section>

      <x-ui.form-section field="Phone Number" required="false">
        <div class="relative flex">
          <div class="absolute inset-y-0 left-0 flex items-center p-2 overflow-hidden border-r border-gray-300">
            +62</div>
          <x-jet-input class="w-full pl-14" wire:model.defer="user.phone_number" type="number" />
        </div>
        @error('user.phone_number')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>

      <x-ui.form-section field="Birth Date" required="false">
        <x-jet-input wire:model.defer="user.birth_date" type="date" />
        @error('user.birth_date')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>
      <x-ui.form-section field="Address" required="false">
        <x-ui.textarea wire:model.defer="user.address" />
        @error('user.address')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>

      <x-ui.form-section field="Password" required="true">
        <x-jet-input wire:model.defer="password" type="password" />
        @error('password')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>

      <x-ui.form-section field="Password Confirmation" required="true">
        <x-jet-input wire:model.defer="password_confirmation" type="password" />
        @error('password_confirmation')
          <x-message.validation type="error">{{ $message }}</x-message.validation>
        @enderror
      </x-ui.form-section>

      <x-slot name="actions">
        <x-jet-button type="submit">{{ $buttonText }}
          <x-ui.loading-indicator wire:target="submit" />
        </x-jet-button>
      </x-slot>
    </x-ui.form>
  </x-ui.card>
</div>
