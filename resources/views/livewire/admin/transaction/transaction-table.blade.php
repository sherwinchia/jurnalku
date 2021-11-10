<x-ui.table>
    <x-slot name="header">
        <div class="flex flex-col gap-2 lg:flex-row">
            <x-jet-input wire:model.debounce.500ms="search" class="" type="text" placeholder="Search" />
            <x-ui.select class="" wire:model="perPage">
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
            </x-ui.select>
        </div>

        @if (in_array("create", $actions))
        <div class="flex items-center">
            <x-jet-button wire:click="createTransaction" wire:loading.attr="disabled">
                Create
                <span wire:loading wire:target="createTransaction"
                    class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                </span>
            </x-jet-button>
        </div>
        @endif
    </x-slot>
    <thead>
        <x-ui.table-row>
            @foreach ($columns as $column)
            @if ( array_key_exists("field", $column) && $column["field"] === "action")
            <th class="px-6 py-3 text-sm leading-4 tracking-wider border-b-2">
                {{ $column["name"] }}
            </th>
            @else
            <th class="px-6 py-3 text-sm leading-4 tracking-wider text-left border-b-2">
                @if(array_key_exists("field", $column) && isset($column["field"]))
                <x-ui.sort-button target-field="{{ $column['field'] }}" :sort-field="$sortField" :sort-asc="$sortAsc"
                    class="font-medium" wire:click.prevent="sortBy('{{$column['field']}}')">
                    {{ $column["name"] }}
                </x-ui.sort-button>
                @else
                {{ $column["name"] }}
                @endif
            </th>
            @endif
            @endforeach
        </x-ui.table-row>
    </thead>

    <tbody>
        @foreach ($transactions as $transaction)
        <x-ui.table-row>
            @foreach ($columns as $column)
            @if (array_key_exists("field", $column) && $column["field"] === "action")
            <td class="px-6 py-4 text-sm leading-5 text-black border-b whitespace-nowrap">
                <div class="flex justify-center text-gray-600">
                    @foreach ($actions as $action)
                    @if ($action === "show")
                    <a class="mx-1 text-lg" role="button" href="{{ route('admin.transactions.show', $transaction->id)
                            }}">
                        <x-icon.eye class="w-5 h-5" />
                    </a>
                    @elseif ($action === "edit")
                    <a class="mx-1 text-lg" role="button" href="{{ route('admin.transactions.edit', $transaction->id)
                            }}">
                        <x-icon.pencil-alt class="w-5 h-5" />
                    </a>
                    @elseif ($action === "delete")
                    <a class="mx-1 text-lg" role="button"
                        wire:click="showModal('{{Crypt::encrypt($transaction->id)}}')">
                        <x-icon.trash class="w-5 h-5" />
                    </a>
                    @endif
                    @endforeach
                </div>
            </td>
            @else
            <td class="px-6 py-4 text-sm leading-5 text-black border-b whitespace-nowrap">
                @if (array_key_exists("relation", $column) && isset($column["relation"]))
                @if (array_key_exists("format", $column) && isset($column["format"]))
                @if (count($column["format"]) > 1)
                {{ $column["format"][0](data_get($transaction,$column["relation"]), implode(",",
                array_slice($column["format"], 1))) }}
                @else
                {{ $column["format"][0](data_get($transaction,$column["relation"])) }}
                @endif
                @else
                {{ data_get($transaction,$column["relation"]) }}
                @endif
                @else
                @if (array_key_exists("format", $column) && isset($column["format"]))
                @if (count($column["format"]) > 1)
                {{ $column["format"][0](data_get($transaction,$column["field"]), implode(",",
                array_slice($column["format"],
                1))) }}
                @else
                {{ $column["format"][0](data_get($transaction,$column["field"])) }}
                @endif
                @elseif(array_key_exists("custom", $column) && isset($column["custom"]))
                @if($column['field'] == 'status')
                <x-ui.status type="{{ data_get($transaction,$column['field']) }}">{{ ucfirst(data_get($transaction,$column["field"])) }}</x-ui.status>
                @endif
                @else
                {{ data_get($transaction,$column["field"]) }}
                @endif
                @endif
            </td>
            @endif
            @endforeach
        </x-ui.table-row>
        @endforeach
    </tbody>

    <x-slot name="footer">
        <div class="mt-4 sm:flex-1 sm:flex sm:items-center sm:justify-between work-sans">
            <div class="py-3">
                <p class="text-sm leading-5">
                    Showing
                    <span class="font-medium">{{ $transactions->firstItem() }}</span>
                    to
                    <span class="font-medium">{{ $transactions->lastItem() }}</span>
                    of
                    <span class="font-medium">{{ $transactions->total() }}</span>
                    results
                </p>
            </div>
            <div class="inline-block">
                {{ $transactions->links() }}
            </div>
        </div>
        </div>
        <x-jet-dialog-modal wire:model="modalVisible">
            <x-slot name="title">
                Delete Transaction
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
                        class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                    </span>
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-ui.table>