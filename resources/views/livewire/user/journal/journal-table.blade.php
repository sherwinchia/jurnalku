<x-ui.table>
        <x-slot name="header">
            <div class="flex flex-col gap-2 lg:flex-row">
                <x-ui.form-section field="Portfolio" required="false">
                    <x-ui.select wire:model="selectedPortfolio" wire:ignore>
                        @foreach($portfolios as $portfolio)
                        <option value="{{ Crypt::encrypt($portfolio->id) }}">{{ $portfolio->name }}</option>
                        @endforeach
                    </x-ui.select>
                </x-ui.form-section>
                <!-- <x-jet-input wire:model="search" class="" type="text" placeholder="Search" /> -->
                <x-ui.form-section field="Show" required="false">
                <x-ui.select class="" wire:model="perPage">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </x-ui.select>
            </x-ui.form-section>
            </div>

            <div class="flex items-center">
                <x-jet-button wire:click="$toggle('addTradeModal')" wire:loading.attr="disabled">
                    Add Trade
                    <span wire:loading wire:target="addTrade"
                        class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                    </span>
                </x-jet-button>
            </div>
        </x-slot>
        <thead>
            <x-ui.table-row>
                @foreach ($columns as $column)
                    @if ( array_key_exists("sortable", $column) && $column["sortable"] === true)
                    <x-ui.table-header>
                        <a wire:click.prevent="sortBy('{{ $column['field'] }}')" role="button">{{ $column["name"] }}</a>
                        @include("admin.partials.sort-icon", ["field"=>$column["field"] ])
                    </x-ui.table-header>
                    @else
                    <x-ui.table-header>
                        {{ $column["name"] }}
                    </x-ui.table-header>
                    @endif
                @endforeach
            </x-ui.table-row>
        </thead>

        <tbody>
            @foreach ($trades as $trade)
            <x-ui.table-row class="{{ $trade->gain_loss > 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                @foreach ($columns as $column)
                @if (array_key_exists("field", $column) && $column["field"] === "action")
                <x-ui.table-data>
                    <div class="flex">
                        @foreach ($actions as $action)
                        @if ($action === "show")
                        <a class="mx-1 text-lg" role="button" href="{{ route('admin.trades.show', $trade->id)
                            }}">
                            <x-icon.eye class="w-5 h-5" />
                        </a>
                        @elseif ($action === "edit")
                        <a class="mx-1 text-lg" role="button" href="{{ route('admin.trades.edit', $trade->id)
                            }}">
                            <x-icon.pencil-alt class="w-5 h-5" />
                        </a>
                        @elseif ($action === "delete")
                        <a class="mx-1 text-lg" role="button" wire:click="showModal('{{Crypt::encrypt($trade->id)}}')">
                            <x-icon.trash class="w-5 h-5" />
                        </a>
                        @endif
                        @endforeach
                    </div>
                </x-ui.table-data>
                @else
                <x-ui.table-data>
                    @if (array_key_exists("relation", $column) && isset($column["relation"]))
                    @if (array_key_exists("format", $column) && isset($column["format"]))
                    @if (count($column["format"]) > 1)
                    {{ $column["format"][0](data_get($trade,$column["relation"]), implode(",",
                    array_slice($column["format"], 1))) }}
                    @else
                    {{ $column["format"][0](data_get($trade,$column["relation"])) }}
                    @endif
                    @else
                    {{ data_get($trade,$column["relation"]) }}
                    @endif
                    @else
                    @if (array_key_exists("format", $column) && isset($column["format"]))
                    @if (count($column["format"]) > 1)
                    {{ $column["format"][0](data_get($trade,$column["field"]), implode(",", array_slice($column["format"],
                    1))) }}
                    @else
                    {{ $column["format"][0](data_get($trade,$column["field"])) }}
                    @endif
                    @else
                    {{ data_get($trade,$column["field"]) }}
                    @endif
                    @endif
                </x-ui.table-data>
                @endif
                @endforeach
            </x-ui.table-row>
            @endforeach
        </tbody>

        <x-slot name="footer">
            <div class="mt-4 sm:flex-1 sm:flex sm:items-center sm:justify-between work-sans">
                <div>
                    <p class="text-sm leading-5">
                        Showing
                        <span class="font-medium">{{ $trades->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $trades->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $trades->total() }}</span>
                        results
                    </p>
                </div>
                <div class="inline-block">
                    {{ $trades->links() }}
                </div>
            </div>
            </div>

            <x-jet-dialog-modal wire:model="addTradeModal">
                <x-slot name="title">
                    Add Trade
                </x-slot>

                <x-slot name="content">
                    <x-ui.alt-form method="POST">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                            <x-ui.form-section field="Instrument" required="true" class="col-span-4 sm:col-span-2">
                                <x-ui.select wire:model.lazy="trade.instrument">
                                    <option value="null" disabled>Choose instrument</option>
                                    @foreach($settings->instruments as $instrument)
                                    <option value="{{ $instrument }}">{{ $instrument }}</option>
                                    @endforeach
                                </x-ui.select>
                                @error("trade.instrument")
                                <x-message.validation type="error">{{ $message }}</x-message.validation>
                                @enderror
                            </x-ui.form-section>

                            <x-ui.form-section field="Setup" required="false" class="col-span-4 sm:col-span-2">
                                <x-ui.select wire:model.lazy="trade.setup">
                                    <option value="null" disabled>Choose setup</option>
                                    @foreach($settings->setups as $setup)
                                    <option value="{{ $setup }}">{{ $setup }}</option>
                                    @endforeach
                                </x-ui.select>
                                @error("trade.setup")
                                <x-message.validation type="error">{{ $message }}</x-message.validation>
                                @enderror
                            </x-ui.form-section>

                            <x-ui.form-section field="Entry Date" required="true" class="col-span-4 sm:col-span-2">
                                <x-jet-input wire:model.defer="trade.entry_date" type="datetime-local" />
                                @error("trade.entry_date")
                                <x-message.validation type="error">{{ $message }}</x-message.validation>
                                @enderror
                            </x-ui.form-section>

                            <x-ui.form-section field="Exit Date" required="true" class="col-span-4 sm:col-span-2">
                                <x-jet-input wire:model.defer="trade.exit_date" type="datetime-local" />
                                @error("trade.exit_date")
                                <x-message.validation type="error">{{ $message }}</x-message.validation>
                                @enderror
                            </x-ui.form-section>

                            <x-ui.form-section field="Entry Price" required="true" class="col-span-4 sm:col-span-2">
                                <div class="relative flex w-full mt-1">
                                    <div class="absolute inset-y-0 left-0 flex items-center p-2 overflow-hidden border-r border-gray-300">
                                        {{ $settings->generals->currency }}
                                    </div>
                                    <x-jet-input wire:model.defer="trade.entry_price" type="number" class="w-full pl-11" />
                                </div>
                                @error("trade.entry_price")
                                <x-message.validation type="error">{{ $message }}</x-message.validation>
                                @enderror
                            </x-ui.form-section>

                            <x-ui.form-section field="Exit Price" required="true" class="col-span-4 sm:col-span-2">
                                <div class="relative flex w-full mt-1">
                                    <div class="absolute inset-y-0 left-0 flex items-center p-2 overflow-hidden border-r border-gray-300">
                                        {{ $settings->generals->currency }}
                                    </div>
                                    <x-jet-input wire:model.defer="trade.exit_price" type="number" class="w-full pl-11" />
                                </div>
                                @error("trade.exit_price")
                                <x-message.validation type="error">{{ $message }}</x-message.validation>
                                @enderror
                            </x-ui.form-section>



                            <x-ui.form-section field="Mistake" required="true" class="col-span-4 sm:col-span-2">
                                <x-ui.select wire:model.lazy="trade.mistake">
                                    <option value="null" disabled>Choose mistake</option>
                                    @foreach($settings->mistakes as $mistake)
                                    <option value="{{ $mistake }}">{{ $mistake }}</option>
                                    @endforeach
                                </x-ui.select>
                                @error("trade.mistake")
                                <x-message.validation type="error">{{ $message }}</x-message.validation>
                                @enderror
                            </x-ui.form-section>
                        </div>
                    </x-ui.form>
                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$toggle('addTradeModal')" wire:loading.attr="disabled">
                        Cancel
                    </x-jet-secondary-button>

                    <x-jet-button class="ml-2" wire:click="addTrade" wire:loading.attr="disabled">
                        Add
                        <span wire:loading wire:target="addTrade"
                            class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                        </span>
                    </x-jet-button>
                </x-slot>
            </x-jet-dialog-modal>

            <x-jet-dialog-modal wire:model="deleteTradeModal">
                <x-slot name="title">
                    Delete trade
                </x-slot>

                <x-slot name="content">
                    This action can not be recovered!
                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$toggle('deleteTradeModal')" wire:loading.attr="disabled">
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