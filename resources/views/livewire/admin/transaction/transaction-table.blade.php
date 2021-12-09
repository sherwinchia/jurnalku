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

    @if (in_array('create', $actions))
      <div class="flex items-center">
        <x-jet-button wire:click="createTransaction" wire:loading.attr="disabled">
          Create
          <x-ui.loading-indicator wire:target="createTransaction" />
        </x-jet-button>
      </div>
    @endif
  </x-slot>
  <thead>
    <x-ui.table-row>
      @foreach ($columns as $column)
        @if (array_key_exists('field', $column) && $column['field'] === 'action')
          <x-ui.table-header class="text-center">
            {{ $column['name'] }}
          </x-ui.table-header>
        @else
          <x-ui.table-header>
            @if (array_key_exists('field', $column) && isset($column['field']))
              <x-ui.sort-button target-field="{{ $column['field'] }}" :sort-field="$sortField" :sort-asc="$sortAsc"
                class="font-medium" wire:click.prevent="sortBy('{{ $column['field'] }}')">
                {{ $column['name'] }}
              </x-ui.sort-button>
            @else
              {{ $column['name'] }}
            @endif
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
            <x-ui.table-data>
              <div class="flex justify-center ">
                @foreach ($actions as $action)
                  @if ($action === 'show')
                    <a class="mx-1 text-lg" role="button"
                      href="{{ route('admin.transactions.show', $transaction->id) }}">
                      <x-icon.eye class="w-5 h-5" />
                    </a>
                  @elseif ($action === "edit")
                    @if ($transaction->status == 'pending')
                      <a class="mx-1 text-lg" role="button" wire:click="showEditModal({{ $transaction->id }})">
                        <x-icon.pencil-alt class="w-5 h-5" />
                      </a>
                    @endif
                    {{-- <a class="mx-1 text-lg" role="button"
                      href="{{ route('admin.transactions.edit', $transaction->id) }}">
                      <x-icon.pencil-alt class="w-5 h-5" />
                    </a> --}}
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
            <x-ui.table-data>
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
    </div>
    <x-jet-dialog-modal wire:model="editModalVisiblity">
      <x-slot name="title">
        Edit Transaction
      </x-slot>

      <x-slot name="content">
        <x-ui.alt-form wire:submit.prevent="submit">
          <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
            <x-ui.form-section field="Status" required="true" class="">
              <x-ui.select wire:model.defer="transactionStatus">
                <option value="null" disabled>Choose one type</option>
                <option value="pending">Pending</option>
                <option value="success">Success</option>
                <option value="fail">Fail</option>
                <option value="cancelled">Cancelled</option>
                <option value="expired">Expired</option>
              </x-ui.select>
              @error('transaction.status')
                <x-message.validation type="error">{{ $message }}</x-message.validation>
              @enderror
            </x-ui.form-section>
            <x-ui.form-section field="Note" required="true" class="col-span-full">
              <x-ui.textarea wire:model.defer="transactionNote"></x-ui.textarea>
              @error('transaction.currency')
                <x-message.validation type="error">{{ $message }}</x-message.validation>
              @enderror
            </x-ui.form-section>
          </div>
        </x-ui.alt-form>
      </x-slot>

      <x-slot name="footer">
        <x-jet-button class="ml-2" wire:click="submit" wire:loading.attr="disabled">
          Update
          <x-ui.loading-indicator wire:target="submit" />
        </x-jet-button>

        <x-jet-secondary-button wire:click="$toggle('editModalVisiblity')" wire:loading.attr="disabled">
          Cancel
        </x-jet-secondary-button>
      </x-slot>
    </x-jet-dialog-modal>
  </x-slot>
</x-ui.table>
