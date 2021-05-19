<div class="flex-1 flex justify-center overflow-y-hidden">
    <div class="card w-full max-w-xl">
        <div class="card-header">
            <p>{{ $buttonText }} User</p>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="submit" class="flex-none flex flex-col justify-between">

                <section>
                    <div class="input-group">
                        <label for="name">Name <span class="text-red-500">*</span></label>
                        <input wire:model.defer="name" type="text">
                        @error('name') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </section>

                @if ($edit)
                    <section>
                        <div class="input-group">
                            <label for="email">Email <span class="text-red-500">*</span></label>
                            <input class="text-gray-400 bg-gray-200" wire:model.defer="email" type="email" disabled>
                            @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </section>
                @else
                    <section>
                        <div class="input-group">
                            <label for="email">Email <span class="text-red-500">*</span></label>
                            <input wire:model.defer="email" type="email">
                            @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </section>
                @endif

                <section>
                    <div class="input-group">
                        <label for="role">Role <span class="text-red-500">*</span></label>
                        <select wire:model="role_id">
                            <option value="null" disabled>Choose one role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </section>

                <section>
                    <div class="input-group">
                        <label for="password">Password @if (!$edit)
                                <span class="text-red-500">*</span>
                            @endif</label>
                        <input wire:model.defer="password" type="password">
                        @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </section>

                <section>
                    <div class="input-group">
                        <label for="password">Confirm Password @if (!$edit)
                                <span class="text-red-500">*</span>
                            @endif</label>
                        <input wire:model.defer="password_confirmation" type="password">
                        @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </section>

                <section>
                    <div class="input-group">
                        <label for="phone_number">Phone Number</label>
                        <input wire:model.defer="phone_number" type="number" min="0">
                        @error('phone_number') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </section>

                <section>
                    <div class="input-group">
                        <label for="address">Address</label>
                        <textarea wire:model.defer="address" type="text"></textarea>
                        @error('address') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </section>


                <div>
                    <x-jet-button type="button" wire:click.prevent="submit()" wire:loading.attr="disabled" class="">
                        {{ $buttonText }}
                        <span wire:loading wire:target="submit"
                            class="ml-2 animate-spin rounded-full h-3 w-3 border-t-2 border-b-2 border-white">
                        </span>
                    </x-jet-button>
                </div>
            </form>
        </div>
    </div>
</div>
