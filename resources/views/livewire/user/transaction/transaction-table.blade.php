<div>
  <div>
    <x-ui.table>
      <thead>
        <x-ui.table-row>
          @foreach ($columns as $column)
            @if (array_key_exists('sortable', $column) && $column['sortable'] === true)
              <x-ui.table-header class="{{ $column['align'] ?? '' }}">
                <x-ui.sort-button target-field="{{ $column['field'] }}" :sort-field="$sortField" :sort-asc="$sortAsc"
                  class="font-medium" wire:click.prevent="sortBy('{{ $column['field'] }}')">
                  {{ $column['name'] }}
                </x-ui.sort-button>
              </x-ui.table-header>
            @else
              <x-ui.table-header class="{{ $column['align'] ?? '' }}">
                {{ $column['name'] }}
              </x-ui.table-header>
            @endif
          @endforeach
        </x-ui.table-row>
      </thead>

      <tbody>
        @foreach ($transactions as $transaction)
          <x-ui.table-row>
            @foreach ($columns as $column)
              @if (array_key_exists('field', $column) && $column['field'] === 'action')
                <x-ui.table-data class="{{ $column['align'] ?? '' }}">
                  <div class="flex text-gray-600">
                    @foreach ($actions as $action)
                      @if ($action === 'show')
                        <a class="mx-1 text-lg" role="button" wire:click="showDetailModal({{ $transaction->id }})">
                          <x-icon.eye class="w-5 h-5" />
                        </a>
                      @elseif ($action === "edit")
                        <a class="mx-1 text-lg" role="button"
                          href="{{ route('user.transactions.edit', $transaction->id) }}">
                          <x-icon.pencil-alt class="w-5 h-5" />
                        </a>
                      @elseif ($action === "delete")
                        <a class="mx-1 text-lg" role="button"
                          wire:click="showModal('{{ Crypt::encrypt($transaction->id) }}')">
                          <x-icon.trash class="w-5 h-5" />
                        </a>
                      @endif
                    @endforeach
                  </div>
                </x-ui.table-data>
              @else
                <x-ui.table-data class="{{ $column['align'] ?? '' }}">
                  @if (array_key_exists('relation', $column) && isset($column['relation']))
                    @if (array_key_exists('format', $column) && isset($column['format']))
                      @if (count($column['format']) > 1)
                        {{ $column['format'][0](data_get($transaction, $column['relation']), implode(',', array_slice($column['format'], 1))) }}
                      @else
                        {{ $column['format'][0](data_get($transaction, $column['relation'])) }}
                      @endif
                    @else
                      {{ data_get($transaction, $column['relation']) }}
                    @endif
                  @else
                    @if (array_key_exists('format', $column) && isset($column['format']))
                      @if (count($column['format']) > 1)
                        {{ $column['format'][0](data_get($transaction, $column['field']), implode(',', array_slice($column['format'], 1))) }}
                      @else
                        {{ $column['format'][0](data_get($transaction, $column['field'])) }}
                      @endif
                    @elseif(array_key_exists("custom", $column) && isset($column["custom"]))
                      @if ($column['field'] == 'status')
                        <x-ui.status type="{{ data_get($transaction, $column['field']) }}">
                          {{ ucfirst(data_get($transaction, $column['field'])) }}</x-ui.status>
                      @endif
                    @else
                      {{ data_get($transaction, $column['field']) }}
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
      </x-slot>
    </x-ui.table>
    @if (isset($targetTransaction))
      <x-jet-dialog-modal wire:model="detailModal">
        <x-slot name="title">
          Transaction Details
          <x-ui.status type="{{ $targetTransaction->status }}">{{ ucfirst($targetTransaction->status) }}
          </x-ui.status>
        </x-slot>
        <x-slot name="content">
          <div class="flex-1">
            <div class="grid grid-cols-1 gap-1 mb-3 lg:grid-cols-3">
              <div class="">
                ID
              </div>
              <div class="col-span-2">
                {{ $targetTransaction->reference }}#{{ $targetTransaction->id }}
              </div>
              <div class="">
                Date
              </div>
              <div class="col-span-2">
                {{ date_to_human($targetTransaction->created_at, 'd F Y, h:i A') }}
              </div>
              <div class="">
                Latest
              </div>
              <div class="col-span-2">
                {{ date_to_human($targetTransaction->updated_at, 'd F Y, h:i A') }}
              </div>
            </div>

            <div class="mb-3">
              <h5 class="mb-2 font-medium">Package Details</h5>
              <div class="grid grid-cols-1 gap-1 lg:grid-cols-3">
                <div class="">
                  Name
                </div>
                <div class="col-span-2">
                  {{ $targetTransaction->package->name }}
                </div>
                <div class="">
                  Duration
                </div>
                <div class="col-span-2">
                  {{ $targetTransaction->package->duration }}days
                </div>
                <div class="">
                  Price
                </div>
                <div class="col-span-2">
                  {{ decimal_to_human($targetTransaction->package->price, 'Rp') }}
                </div>
              </div>
            </div>
            <div>
              <h5 class="mb-2 font-medium">Payment Details</h5>
              <div class="grid grid-cols-1 gap-1 lg:grid-cols-3">
                <div class="">
                  Gross Total
                </div>
                <div class="col-span-2">
                  {{ decimal_to_human($targetTransaction->gross_total, 'Rp') }}
                </div>
                <div class="">
                  Discount <span class="text-xs italic">({{ $targetTransaction->promoCode->code ?? '' }})</span>
                </div>
                <div class="col-span-2">
                  -{{ decimal_to_human($targetTransaction->discount, 'Rp') }}
                </div>
                <div class="">
                  Net Total
                </div>
                <div class="col-span-2">
                  {{ decimal_to_human($targetTransaction->net_total, 'Rp') }}
                </div>
              </div>
            </div>
          </div>
        </x-slot>
    @endif
    <x-slot name="footer">
      <x-jet-secondary-button wire:click="$toggle('detailModal')" wire:loading.attr="disabled">
        Close
      </x-jet-secondary-button>
    </x-slot>
    </x-jet-dialog-modal>
  </div>

</div>