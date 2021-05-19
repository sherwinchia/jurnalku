<div class="data-table overflow-x-auto">
    <div class="top">
        <div class="flex justify-between mb-2">
            <div class="flex space-x-2">
                <div class="input-group">
                    <input wire:model="search" class="" type="text" placeholder="Search">
                </div>
                <div class="input-group">
                    <select class="" wire:model="perPage">
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                </div>
            </div>
            <div>
                <x-jet-button wire:click="createUser" wire:loading.attr="disabled">
                    Create
                    <span wire:loading wire:target="createUser"
                        class="ml-2 animate-spin rounded-full h-3 w-3 border-t-2 border-b-2 border-white">
                    </span>
                </x-jet-button>
            </div>

        </div>
    </div>
    <div class="bottom">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="text-left">
                        <a wire:click.prevent="sortBy('id')" role="button">ID</a>
                        @include('admin.partials.sort-icon', ['field'=>'id'])
                    </th>
                    <th class="text-left">
                        <a wire:click.prevent="sortBy('name')" role="button">Name</a>
                        @include('admin.partials.sort-icon', ['field'=>'name'])
                    </th>

                    <th class="text-left">
                        Role
                    </th>

                    <th>
                        Action
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap border-b">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm leading-5 text-gray-800">{{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="non-id">
                            {{ $user->name }}
                        </td>

                        <td class="non-id">
                            {{ $user->role->name }}
                        </td>

                        <td class="non-id">
                            <div class="flex justify-center text-gray-600">
                                <a class="mx-1 text-lg" role="button"
                                    href="{{ route('admin.users.edit', $user->id) }}">
                                    <i class="far fa-edit"></i>
                                </a>
                                <a class="mx-1 text-lg" role="button" wire:click="showModal({{ $user->id }})">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="sm:flex-1 sm:flex sm:items-center sm:justify-between mt-4 work-sans">
            <div>
                <p class="text-sm leading-5">
                    Showing
                    <span class="font-medium">{{ $users->firstItem() }}</span>
                    to
                    <span class="font-medium">{{ $users->lastItem() }}</span>
                    of
                    <span class="font-medium">{{ $users->total() }}</span>
                    results
                </p>
            </div>
            <div class="inline-block">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    <x-jet-dialog-modal wire:model="modalVisible">
        <x-slot name="title">
            Delete User
        </x-slot>

        <x-slot name="content">
            This action can not be recovered!
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalVisible')" wire:loading.attr="disabled">
                Cancel
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                Delete
                <span wire:loading wire:target="delete"
                    class="ml-2 animate-spin rounded-full h-3 w-3 border-t-2 border-b-2 border-white">
                </span>
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
