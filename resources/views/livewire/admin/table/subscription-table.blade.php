<div class="data-table overflow-x-auto">
<div class="top">
    <div class="flex justify-between items-center mb-2">
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
        @if (in_array("create", $actions))
        <x-jet-button wire:click="createSubscription" wire:loading.attr="disabled">
            Create
            <span wire:loading wire:target="createSubscription"
                class="ml-2 animate-spin rounded-full h-3 w-3 border-t-2 border-b-2 border-white">
            </span>
        </x-jet-button>
        @endif
    </div>
</div>
<div class="bottom">
    <table class="min-w-full">
        <thead>
            <tr>
            @foreach ($columns as $column)
                @if ( $column["field"] === "action") 
                <th>
                    {{ $column["name"] }}
                </th>
                @else
                <th class="text-left">
                    @if(isset($column["field"]))
                        <a wire:click.prevent="sortBy('{{ $column['field'] }}')" role="button">{{ $column["name"] }}</a>
                        @include("admin.partials.sort-icon", ["field"=>$column["field"] ])
                    @else
                        {{ $column["name"] }}
                    @endif
                </th>
                @endif
            @endforeach
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($subscriptions as $subscription)
                <tr>
                @foreach ($columns as $column)
                @if ($column["field"] === "action")
                    <td class="data-item">
                        <div class="flex justify-center text-gray-600">
                        @foreach ($actions as $action)
                            @if ($action === "show")
                                <a class="mx-1 text-lg" role="button" href="{{ route("admin.subscriptions.show", $subscription->id) }}">
                                    <i class="far fa-eye"></i>
                                </a>    
                            @elseif ($action === "edit")
                                <a class="mx-1 text-lg" role="button" href="{{ route("admin.subscriptions.edit", $subscription->id) }}">
                                    <i class="far fa-edit"></i>
                                </a>    
                            @elseif ($action === "delete")
                                <a class="mx-1 text-lg" role="button" wire:click="showModal('{{Crypt::encrypt($subscription->id)}}')">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            @endif
                        @endforeach
                        </div>
                    </td>
                @else
                    <td class="data-item">
                        @if (isset($column["relation"]))
                            {{ data_get($subscription,$column["relation"]) }}
                        @else
                            {{ data_get($subscription,$column["field"]) }}
                        @endif
                    </td>
                @endif
            @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="sm:flex-1 sm:flex sm:items-center sm:justify-between mt-4 work-sans">
        <div>
            <p class="text-sm leading-5">
                Showing
                <span class="font-medium">{{ $subscriptions->firstItem() }}</span>
                to
                <span class="font-medium">{{ $subscriptions->lastItem() }}</span>
                of
                <span class="font-medium">{{ $subscriptions->total() }}</span>
                results
            </p>
        </div>
        <div class="inline-block">
            {{ $subscriptions->links() }}
        </div>
    </div>
</div>
<x-jet-dialog-modal wire:model="modalVisible">
    <x-slot name="title">
        Delete Subscription
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