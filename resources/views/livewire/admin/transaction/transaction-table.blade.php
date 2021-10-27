<x-ui.table>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row gap-2">
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
                    class="ml-2 animate-spin rounded-full h-3 w-3 border-t-2 border-b-2 border-white">
                </span>
            </x-jet-button>
        </div>
        @endif
    </x-slot>
    <thead>
        <x-ui.table-row>
            @foreach ($columns as $column)
            @if ( array_key_exists("field", $column) && $column["field"] === "action")
            <th class="px-6 py-3 border-b-2 leading-4 tracking-wider text-sm">
                {{ $column["name"] }}
            </th>
            @else
            <th class="px-6 py-3 border-b-2 leading-4 tracking-wider text-sm text-left">
                @if(array_key_exists("field", $column) && isset($column["field"]))
                <a wire:click.prevent="sortBy('{{ $column['field'] }}')" role="button">{{ $column["name"] }}</a>
                @include("admin.partials.sort-icon", ["field"=>$column["field"] ])
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
            <td class="px-6 py-4 whitespace-nowrap border-b text-black text-sm leading-5">
                <div class="flex justify-center text-gray-600">
                    @foreach ($actions as $action)
                    @if ($action === "show")
                    <a class="mx-1 text-lg" role="button" href="{{ route('admin.transactions.show', $transaction->id)
                            }}">
                        <i class="far fa-eye"></i>
                    </a>
                    @elseif ($action === "edit")
                    <a class="mx-1 text-lg" role="button" href="{{ route('admin.transactions.edit', $transaction->id)
                            }}">
                        <i class="far fa-edit"></i>
                    </a>
                    @elseif ($action === "delete")
                    <a class="mx-1 text-lg" role="button"
                        wire:click="showModal('{{Crypt::encrypt($transaction->id)}}')">
                        <i class="far fa-trash-alt"></i>
                    </a>
                    @endif
                    @endforeach
                </div>
            </td>
            @else
            <td class="px-6 py-4 whitespace-nowrap border-b text-black text-sm leading-5">
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
        <div class="sm:flex-1 sm:flex sm:items-center sm:justify-between mt-4 work-sans">
            <div>
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
                        class="ml-2 animate-spin rounded-full h-3 w-3 border-t-2 border-b-2 border-white">
                    </span>
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-ui.table>