<x-ui.table>
    <x-slot name="header">
        <div class="flex w-full gap-2 lg:w-1/5">
            <x-ui.form-section class="w-1/2" field="Portfolio" required="false">
                <x-ui.select wire:model="selectedPortfolioId" wire:change="updatePortfolio" wire:ignore>
                    @foreach($portfolios as $portfolio)
                    <option value="{{ Crypt::encrypt($portfolio->id) }}">{{ $portfolio->name }}</option>
                    @endforeach
                </x-ui.select>
            </x-ui.form-section>
            <!-- <x-jet-input wire:model="search" class="" type="text" placeholder="Search" /> -->
            <x-ui.form-section class="w-1/2" field="Show" required="false">
                <x-ui.select wire:model="perPage">
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </x-ui.select>
            </x-ui.form-section>
        </div>

        <div class="flex items-center gap-2">
            <x-jet-button wire:click="exportPortfolio" wire:loading.attr="disabled">
                Export Portfolio
                <span wire:loading wire:target="exportPortfolio"
                    class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                </span>
            </x-jet-button>
            <x-jet-button wire:click="showAddTradeModal" wire:loading.attr="disabled">
                Add Trade
                <span wire:loading wire:target="showAddTradeModal"
                    class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                </span>
            </x-jet-button>
        </div>
    </x-slot>
    <thead>
        <x-ui.table-row>
            @foreach ($columns as $column)
                @if ( array_key_exists("sortable", $column) && $column["sortable"] === true)
                <x-ui.table-header class="{{ $column['align'] ?? '' }}">
                    <a wire:click.prevent="sortBy('{{ $column['field'] }}')" role="button">{{ $column["name"] }}</a>
                    @include("admin.partials.sort-icon", ["field"=>$column["field"] ])
                </x-ui.table-header>
                @else
                <x-ui.table-header  class="{{ $column['align'] ?? '' }}">
                    {{ $column["name"] }}
                </x-ui.table-header>
                @endif
            @endforeach
        </x-ui.table-row>
    </thead>

    <tbody>
        @foreach ($trades as $trade)
        <x-ui.table-row class="">
            @foreach ($columns as $column)
            @if (array_key_exists("field", $column) && $column["field"] === "action")
            <x-ui.table-data class="{{ $column['align'] ?? '' }}">
                <div class="flex text-gray-700">
                    <a class="mx-1 text-lg" role="button" href="{{ route('user.trades.show', $trade->id) }}">
                        <x-icon.eye class="w-5 h-5" />
                    </a>
                    <a class="mx-1 text-lg" role="button" wire:click="showEditFormModal('{{ $trade->id }}')">
                        <x-icon.pencil-alt class="w-5 h-5" />
                    </a>
                    <a class="mx-1 text-lg" role="button" wire:click="showDeleteModal('{{ $trade->id }}')">
                        <x-icon.trash class="w-5 h-5" />
                    </a>
                </div>
            </x-ui.table-data>
            @else
            <x-ui.table-data class="{{ $column['align'] ?? '' }}">
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
                @if($column["field"]=="status")
                <x-ui.status type="{{ $trade->status }}" class="">{{ ucfirst($trade->status) }}</x-ui.status>
                @else
                {{ data_get($trade,$column["field"]) }}
                @endif
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
            <div class="py-3">
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

        <x-jet-dialog-modal  wire:model="tradeFormModal" class="">
            <x-slot name="title">
                <div class="flex items-center justify-between">
                    <span>{{ $edit ? 'Update' : 'Add' }} Trade</span>
                    @if($edit)
                    <x-ui.status type="{{ $trade->status }}">{{ ucfirst($trade->status) }}</x-ui.status>
                    @endif
                </div>
            </x-slot>
            <x-slot name="content">
                <x-ui.alt-form method="POST" x-data="{activeTab: {{ $tab }}, tabs: ['Entry','Exit','Extra']}">
                    <div class="bg-white">
                        <ul class="flex flex-wrap gap-4 p-0 pb-2">
                            <template x-for="(tab, index) in tabs" :key="index">
                                <li class="pb-1 cursor-pointer text-md"
                                    :class="activeTab===index ? 'text-primary-500 border-primary-500 border-b-2' : ''" @click="activeTab = index"
                                    x-text="tab">
                                </li>
                            </template>
                        </ul>
                    </div>

                    <div class="">
                        <div x-show="activeTab===0" >
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

                                <x-ui.form-section field="Quantity" required="true" class="col-span-4 sm:col-span-2">
                                    <x-jet-input wire:model.defer="trade.quantity" type="number" class="" />
                                    @error("trade.quantity")
                                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                                    @enderror
                                </x-ui.form-section>

                                <x-ui.form-section field="Take Profit" required="true" class="col-span-4 sm:col-span-2">
                                    <div class="relative flex w-full">
                                        <div class="absolute inset-y-0 left-0 flex items-center justify-center w-12 p-2 overflow-hidden text-sm border-r border-gray-300">
                                            {{ $currency }}
                                        </div>
                                        <x-jet-input wire:model.defer="trade.take_profit" type="number" class="w-full pl-14" />
                                    </div>
                                    @error("trade.take_profit")
                                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                                    @enderror
                                </x-ui.form-section>

                                <x-ui.form-section field="Stop Loss" required="true" class="col-span-4 sm:col-span-2">
                                    <div class="relative flex w-full">
                                        <div class="absolute inset-y-0 left-0 flex items-center justify-center w-12 p-2 overflow-hidden text-sm border-r border-gray-300">
                                            {{ $currency }}
                                        </div>
                                        <x-jet-input wire:model.defer="trade.stop_loss" type="number" class="w-full pl-14" />
                                    </div>
                                    @error("trade.stop_loss")
                                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                                    @enderror
                                </x-ui.form-section>

                                <x-ui.form-section field="Entry Date" required="true" class="col-span-4 sm:col-span-2">
                                    <x-jet-input wire:model.defer="trade.entry_date" type="datetime-local" />
                                    @error("trade.entry_date")
                                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                                    @enderror
                                </x-ui.form-section>

                                <x-ui.form-section field="Entry Price" required="true" class="col-span-4 sm:col-span-2">
                                    <div class="relative flex w-full">
                                        <div class="absolute inset-y-0 left-0 flex items-center justify-center w-12 p-2 overflow-hidden text-sm border-r border-gray-300">
                                            {{ $currency }}
                                        </div>
                                        <x-jet-input wire:model.defer="trade.entry_price" type="number" class="w-full pl-14" />
                                    </div>
                                    @error("trade.entry_price")
                                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                                    @enderror
                                </x-ui.form-section>

                                <x-ui.form-section field="Entry Fee" required="true" class="col-span-4 sm:col-span-2">
                                    <div class="relative flex w-full">
                                        <x-ui.select wire:model="entryFeeType" class="absolute inset-y-0 left-0 w-20 text-sm">
                                            <option value="{{ $currency }}">{{ $currency }}</option>
                                            <option value="%">%</option>
                                        </x-ui.select>
                                        <x-jet-input wire:model.defer="trade.entry_fee" type="number" class="w-full" style="padding-left: 5.5rem;"/>
                                    </div>
                                    @error("trade.entry_fee")
                                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                                    @enderror
                                </x-ui.form-section>
                            </div>
                        </div>
                        <div x-show="activeTab===1">
                            <div class="col-span-full">
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                                    <x-ui.form-section field="Exit Date" required="false" class="col-span-4 sm:col-span-2">
                                        <x-jet-input wire:model.defer="trade.exit_date" type="datetime-local" />
                                        @error("trade.exit_date")
                                        <x-message.validation type="error">{{ $message }}</x-message.validation>
                                        @enderror
                                    </x-ui.form-section>
                                    <x-ui.form-section field="Exit Price" required="false" class="col-span-4 sm:col-span-2">
                                        <div class="relative flex w-full">
                                            <div class="absolute inset-y-0 left-0 flex items-center justify-center w-12 p-2 overflow-hidden text-sm border-r border-gray-300">
                                                {{ $currency }}
                                            </div>
                                            <x-jet-input wire:model.defer="trade.exit_price" type="number" class="w-full pl-14" />
                                        </div>
                                        @error("trade.exit_price")
                                        <x-message.validation type="error">{{ $message }}</x-message.validation>
                                        @enderror
                                    </x-ui.form-section>
                                    <x-ui.form-section field="Exit Fee" required="true" class="col-span-4 sm:col-span-2">
                                        <div class="relative flex w-full">
                                            <x-ui.select wire:model="exitFeeType" class="absolute inset-y-0 left-0 w-20 text-sm">
                                                <option value="{{ $currency }}">{{ $currency }}</option>
                                                <option value="%">%</option>
                                            </x-ui.select>
                                            <x-jet-input wire:model.defer="trade.exit_fee" type="number" class="w-full" style="padding-left: 5.5rem;"/>
                                        </div>
                                        @error("trade.exit_fee")
                                        <x-message.validation type="error">{{ $message }}</x-message.validation>
                                        @enderror
                                    </x-ui.form-section>
                                </div>
                            </div>
                        </div>
                        <div x-show="activeTab===2">
                            <div class="col-span-full">
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
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

                                    <x-ui.form-section field="Notes" required="false" class="col-span-full">
                                        <x-ui.textarea wire:model.lazy="trade.note"></x-ui.textarea>
                                        @error("trade.note")
                                        <x-message.validation type="error">{{ $message }}</x-message.validation>
                                        @enderror
                                    </x-ui.form-section>
                                </div>
                            </div>

                            <div class="col-span-full">
                                <x-ui.header class="mb-2 border-b">Screenshots</x-ui.header>
                                <livewire:image-uploader name="trade.images">
                            </div>
                        </div>
                    </div>
                </x-ui.form>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('tradeFormModal')" wire:loading.attr="disabled">
                    Cancel
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="submitTrade" wire:loading.attr="disabled">
                    {{ $edit ? 'Update' : 'Add' }}
                    <span wire:loading wire:target="submitTrade"
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

                <x-jet-danger-button class="ml-2" wire:click="deleteTrade" wire:loading.attr="disabled">
                    Delete
                    <span wire:loading wire:target="deleteTrade"
                        class="w-3 h-3 ml-2 border-t-2 border-b-2 border-white rounded-full animate-spin">
                    </span>
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-ui.table>
