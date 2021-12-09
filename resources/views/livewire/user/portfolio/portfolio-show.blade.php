<x-ui.table>
  <x-slot name="header">
    <div class="flex w-full gap-2 lg:w-1/5">
      <!-- <x-jet-input wire:model="search" type="text" placeholder="Search" /> -->
      <x-ui.form-section class="w-1/2" field="Show" required="false">
        <x-ui.select wire:model="perPage">
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
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
      <x-ui.table-header>
        <x-ui.sort-button target-field="favorite" :sort-field="$sortField" :sort-asc="$sortAsc" class="font-medium"
          wire:click.prevent="sortBy('favorite')">
          Fav
        </x-ui.sort-button>
      </x-ui.table-header>
      <x-ui.table-header>
        <x-ui.sort-button target-field="instrument" :sort-field="$sortField" :sort-asc="$sortAsc" class="font-medium"
          wire:click.prevent="sortBy('instrument')">
          Instrument
        </x-ui.sort-button>
      </x-ui.table-header>
      <x-ui.table-header class="text-center">
        <x-ui.sort-button target-field="quantity" :sort-field="$sortField" :sort-asc="$sortAsc" class="font-medium"
          wire:click.prevent="sortBy('quantity')">
          Quantity
        </x-ui.sort-button>
      </x-ui.table-header>
      <x-ui.table-header class="text-center">
        <x-ui.sort-button target-field="entry_date" :sort-field="$sortField" :sort-asc="$sortAsc" class="font-medium"
          wire:click.prevent="sortBy('entry_date')">
          Entry Date
        </x-ui.sort-button>
      </x-ui.table-header>
      <x-ui.table-header class="text-center">
        <x-ui.sort-button target-field="entry_price" :sort-field="$sortField" :sort-asc="$sortAsc"
          class="font-medium" wire:click.prevent="sortBy('entry_price')">
          Entry Price
        </x-ui.sort-button>
      </x-ui.table-header>
      <x-ui.table-header class="text-center">
        <x-ui.sort-button target-field="exit_price" :sort-field="$sortField" :sort-asc="$sortAsc" class="font-medium"
          wire:click.prevent="sortBy('exit_price')">
          Exit Price
        </x-ui.sort-button>
      </x-ui.table-header>
      <x-ui.table-header class="text-center">
        <x-ui.sort-button target-field="exit_date" :sort-field="$sortField" :sort-asc="$sortAsc" class="font-medium"
          wire:click.prevent="sortBy('exit_date')">
          Exit Date
        </x-ui.sort-button>
      </x-ui.table-header>
      <x-ui.table-header class="text-center">
        <x-ui.sort-button target-field="return" :sort-field="$sortField" :sort-asc="$sortAsc" class="font-medium"
          wire:click.prevent="sortBy('return')">
          Return
        </x-ui.sort-button>
      </x-ui.table-header>
      <x-ui.table-header class="text-center">
        <x-ui.sort-button target-field="return_percentage" :sort-field="$sortField" :sort-asc="$sortAsc"
          class="font-medium" wire:click.prevent="sortBy('return_percentage')">
          Return (%)
        </x-ui.sort-button>
      </x-ui.table-header>
      <x-ui.table-header class="font-medium text-center">
        Hold Time
      </x-ui.table-header>
      <x-ui.table-header class="font-medium text-center">
        Actions
      </x-ui.table-header>
    </x-ui.table-row>
  </thead>
  <tbody>
    @foreach ($trades as $trade)
      <x-ui.table-row>
        <x-ui.table-data class="flex items-center">
          @if ($trade->favorite)
            <button class="flex items-center w-5 h-5 focus:outline-none" wire:loading.attr="disabled"
              wire:click="favorite({{ $trade->id }})">
              <x-icon.solid-star class="w-5 h-5 text-yellow-500" wire:target="favorite('{{ $trade->id }}')" />
            </button>
          @else
            <button class="flex items-center h-5 focus:outline-none" wire:loading.attr="disabled"
              wire:click="favorite({{ $trade->id }})">
              <x-icon.outline-star class="w-5 h-5 " wire:target="favorite('{{ $trade->id }}')" />
            </button>
          @endif
        </x-ui.table-data>
        <x-ui.table-data>
          {{ $trade->instrument }}
        </x-ui.table-data>
        <x-ui.table-data class="text-center">
          {{ decimal_to_human($trade->quantity) }}
        </x-ui.table-data>
        <x-ui.table-data class="text-center">
          {{ date_to_human($trade->entry_date, 'd/m/Y') }}
        </x-ui.table-data>
        <x-ui.table-data class="text-center">
          {{ decimal_to_human($trade->entry_price, $portfolio->currency) }}
        </x-ui.table-data>
        <x-ui.table-data class="text-center">
          {{ isset($trade->exit_date) ? decimal_to_human($trade->exit_price, $portfolio->currency) : '-' }}
        </x-ui.table-data>
        <x-ui.table-data class="text-center">
          {{ isset($trade->exit_date) ? date_to_human($trade->exit_date, 'd/m/Y') : '-' }}
        </x-ui.table-data>
        <x-ui.table-data
          class="{{ isset($trade->return) ? ($trade->return > 0 ? 'text-green-500' : 'text-red-500') : '-' }} text-center">
          {{ isset($trade->exit_date) ? decimal_to_human($trade->return, $portfolio->currency) : '-' }}
        </x-ui.table-data>
        <x-ui.table-data
          class="{{ isset($trade->return) ? ($trade->return > 0 ? 'text-green-500' : 'text-red-500') : '-' }} text-center">
          {{ isset($trade->exit_date) ? decimal_to_human($trade->return_percentage, null, true) : '-' }}
        </x-ui.table-data>
        <x-ui.table-data class="text-center">
          {{ isset($trade->exit_date) ? date_interval($trade->exit_date, $trade->entry_date) : '-' }}
        </x-ui.table-data>
        <x-ui.table-data>
          <div class="flex justify-center">
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

    <x-jet-dialog-modal wire:model="tradeFormModal">
      <x-slot name="title">
        <div class="flex items-center justify-between">
          <span>{{ $edit ? 'Update' : 'Add' }} Trade</span>
        </div>
      </x-slot>
      <x-slot name="content">
        <x-ui.alt-form method="POST" x-data="{activeTab: {{ $tab }}, tabs: ['Entry','Exit','Extra']}">
          <div class="">
            <ul class="flex flex-wrap gap-4 p-0 pb-2">
              <template x-for="(tab, index) in tabs" :key="index">
                <li class="pb-1 cursor-pointer text-md"
                  :class="activeTab===index ? 'text-primary-500 border-primary-500 border-b-2' : ''"
                  @click="activeTab = index" x-text="tab">
                </li>
              </template>
            </ul>
          </div>

          <div>
            <div x-show="activeTab===0">
              <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                <x-ui.form-section field="Instrument" required="true" class="col-span-4 sm:col-span-2">
                  <x-jet-input wire:model.defer="trade.instrument" type="text" list="instruments" />
                  <datalist id="instruments">
                    @foreach ($settings->instruments as $instrument)
                      <option value="{{ $instrument }}">{{ $instrument }}</option>
                    @endforeach
                  </datalist>
                  @error('trade.instrument')
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                  @enderror
                </x-ui.form-section>

                <x-ui.form-section field="Quantity" required="true" class="col-span-4 sm:col-span-2">
                  <x-jet-input wire:model.defer="trade.quantity" type="number" />
                  @error('trade.quantity')
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                  @enderror
                </x-ui.form-section>

                <x-ui.form-section field="Entry Date" required="true" class="col-span-4 sm:col-span-2">
                  <x-jet-input wire:model.defer="trade.entry_date" type="datetime-local" />
                  @error('trade.entry_date')
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                  @enderror
                </x-ui.form-section>

                <x-ui.form-section field="Entry Price" required="true" class="col-span-4 sm:col-span-2">
                  <div class="relative flex w-full">
                    <div
                      class="absolute inset-y-0 left-0 flex items-center justify-center w-12 p-2 overflow-hidden text-sm border-r border-gray-300 dark:border-gray-600">
                      {{ $portfolio->currency }}
                    </div>
                    <x-jet-input wire:model.defer="trade.entry_price" type="number" class="w-full pl-14" />
                  </div>
                  @error('trade.entry_price')
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                  @enderror
                </x-ui.form-section>

                <x-ui.form-section field="Take Profit" required="true" class="col-span-4 sm:col-span-2">
                  <div class="relative flex w-full">
                    <x-ui.select wire:model="takeProfitType" class="absolute inset-y-0 left-0 w-20 text-sm">
                      <option value="{{ $portfolio->currency }}">{{ $portfolio->currency }}
                      </option>
                      <option value="%">%</option>
                    </x-ui.select>
                    <x-jet-input wire:model.defer="trade.take_profit" type="number" class="w-full"
                      style="padding-left: 5.5rem;" />
                  </div>
                  @error('trade.take_profit')
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                  @enderror
                </x-ui.form-section>

                <x-ui.form-section field="Stop Loss" required="true" class="col-span-4 sm:col-span-2">
                  <div class="relative flex w-full">
                    <x-ui.select wire:model="stopLossType" class="absolute inset-y-0 left-0 w-20 text-sm">
                      <option value="{{ $portfolio->currency }}">{{ $portfolio->currency }}
                      </option>
                      <option value="%">%</option>
                    </x-ui.select>
                    <x-jet-input wire:model.defer="trade.stop_loss" type="number" class="w-full"
                      style="padding-left: 5.5rem;" />
                  </div>
                  @error('trade.stop_loss')
                    <x-message.validation type="error">{{ $message }}</x-message.validation>
                  @enderror
                </x-ui.form-section>

                <x-ui.form-section field="Entry Fee" required="true" class="col-span-4 sm:col-span-2">
                  <div class="relative flex w-full">
                    <x-ui.select wire:model="entryFeeType" class="absolute inset-y-0 left-0 w-20 text-sm">
                      <option value="{{ $portfolio->currency }}">{{ $portfolio->currency }}
                      </option>
                      <option value="%">%</option>
                    </x-ui.select>
                    <x-jet-input wire:model.defer="trade.entry_fee" type="number" class="w-full"
                      style="padding-left: 5.5rem;" />
                  </div>
                  @error('trade.entry_fee')
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
                    @error('trade.exit_date')
                      <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                  </x-ui.form-section>
                  <x-ui.form-section field="Exit Price" required="false" class="col-span-4 sm:col-span-2">
                    <div class="relative flex w-full">
                      <div
                        class="absolute inset-y-0 left-0 flex items-center justify-center w-12 p-2 overflow-hidden text-sm border-r border-gray-300 dark:border-gray-600">
                        {{ $portfolio->currency }}
                      </div>
                      <x-jet-input wire:model.defer="trade.exit_price" type="number" class="w-full pl-14" />
                    </div>
                    @error('trade.exit_price')
                      <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                  </x-ui.form-section>
                  <x-ui.form-section field="Exit Fee" required="true" class="col-span-4 sm:col-span-2">
                    <div class="relative flex w-full">
                      <x-ui.select wire:model="exitFeeType" class="absolute inset-y-0 left-0 w-20 text-sm">
                        <option value="{{ $portfolio->currency }}">
                          {{ $portfolio->currency }}
                        </option>
                        <option value="%">%</option>
                      </x-ui.select>
                      <x-jet-input wire:model.defer="trade.exit_fee" type="number" class="w-full"
                        style="padding-left: 5.5rem;" />
                    </div>
                    @error('trade.exit_fee')
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
                    <x-jet-input wire:model.defer="trade.setup" type="text" list="setups" />
                    <datalist id="setups">
                      @foreach ($settings->setups as $setup)
                        <option value="{{ $setup }}">{{ $setup }}</option>
                      @endforeach
                    </datalist>
                    @error('trade.setup')
                      <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                  </x-ui.form-section>

                  <x-ui.form-section field="Mistake" required="false" class="col-span-4 sm:col-span-2">
                    <x-jet-input wire:model.defer="trade.mistake" type="text" list="mistakes" />
                    <datalist id="mistakes">
                      @foreach ($settings->mistakes as $mistake)
                        <option value="{{ $mistake }}">{{ $mistake }}</option>
                      @endforeach
                    </datalist>
                    @error('trade.mistake')
                      <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                  </x-ui.form-section>

                  <x-ui.form-section field="Notes" required="false" class="col-span-full">
                    <x-ui.textarea wire:model.lazy="trade.note"></x-ui.textarea>
                    @error('trade.note')
                      <x-message.validation type="error">{{ $message }}</x-message.validation>
                    @enderror
                  </x-ui.form-section>
                </div>
              </div>
              <!-- <div class="col-span-full">
                <x-ui.header class="mb-2 border-b">Screenshots</x-ui.header>
                <livewire:image-uploader name="trade.images">
              </div> -->
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
        Delete Trade
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

  <x-ui.loading />
</x-ui.table>
