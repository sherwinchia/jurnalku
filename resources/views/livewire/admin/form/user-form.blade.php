<div class="flex-1 flex justify-center overflow-y-hidden">
    <div class="card w-full max-w-xl">
        <div class="card-header">
            <p>{{ $buttonText }} User</p>
        </div>
        <div class="card-body">
            <form wire:submit.prevent="submit" class="flex-none flex flex-col justify-between">
                <div class="overflow-y-auto">
                    <section>
                        <div class="input-group">
                            <label for="name">Name <span class="text-red-500">*</span></label>
                            <input wire:model="name" type="text">
                            @error('name') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </section>

                    @if ($edit)
                        <section>
                            <div class="input-group">
                                <label for="email">Email <span class="text-red-500">*</span></label>
                                <input class="text-gray-400 bg-gray-200" wire:model="email" type="email" disabled>
                                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                            </div>
                        </section>
                    @else
                        <section>
                            <div class="input-group">
                                <label for="email">Email <span class="text-red-500">*</span></label>
                                <input wire:model="email" type="email">
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
                            <label for="password">Password  @if (!$edit)
                                <span class="text-red-500">*</span>
                            @endif</label>
                            <input wire:model="password" type="text">
                            @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </section>

                    <section>
                        <div class="input-group">
                            <label for="phone_number">Phone Number</label>
                            <input wire:model="phone_number" type="text">
                            @error('phone_number') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </section>

                    <section>
                        <div class="input-group">
                            <label for="address">Address</label>
                            <textarea wire:model="address" type="text"></textarea>
                            @error('address') <span class="error-msg">{{ $message }}</span> @enderror
                        </div>
                    </section>

                </div>
                <div>
                    {{-- @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded m-2">
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ $errors->first() }}</span>
                        </div>
                    @endif --}}
                    <x-jet-button type="submit" class="">{{ $buttonText }}</x-jet-button>
                </div>
            </form>
        </div>
    </div>
</div>
