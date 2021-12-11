<x-ui.table>
  <x-slot name="header">
    <div class="flex flex-col gap-2 lg:flex-row">
      <x-jet-input wire:model="search" class="" type="text" placeholder="Search" />
      <x-ui.select class="" wire:model="perPage">
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
      </x-ui.select>
    </div>

    @if (in_array('create', $actions))
      <div class="flex items-center">
        <x-jet-button wire:click="createBlog" wire:loading.attr="disabled">
          Create
          <x-ui.loading-indicator wire:target="createBlog" />
        </x-jet-button>
      </div>
    @endif
  </x-slot>
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
    @foreach ($blogs as $blog)
      <x-ui.table-row>
        @foreach ($columns as $column)
          @if (array_key_exists('field', $column) && $column['field'] === 'action')
            <x-ui.table-data class="{{ $column['align'] ?? '' }}">
              <div class="flex">
                @foreach ($actions as $action)
                  @if ($action === 'show')
                    <a class="mx-1 text-lg" role="button" href="{{ route('admin.blogs.show', $blog->id) }}">
                      <x-icon.eye class="w-5 h-5" />
                    </a>
                  @elseif ($action === "edit")
                    <a class="mx-1 text-lg" role="button" href="{{ route('admin.blogs.edit', $blog->id) }}">
                      <x-icon.pencil-alt class="w-5 h-5" />
                    </a>
                  @elseif ($action === "delete")
                    <a class="mx-1 text-lg" role="button" wire:click="showModal('{{ Crypt::encrypt($blog->id) }}')">
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
                    {{ $column['format'][0](data_get($blog, $column['relation']), implode(',', array_slice($column['format'], 1))) }}
                  @else
                    {{ $column['format'][0](data_get($blog, $column['relation'])) }}
                  @endif
                @else
                  {{ data_get($blog, $column['relation']) }}
                @endif
              @else
                @if (array_key_exists('format', $column) && isset($column['format']))
                  @if (count($column['format']) > 1)
                    {{ $column['format'][0](data_get($blog, $column['field']), implode(',', array_slice($column['format'], 1))) }}
                  @else
                    {{ $column['format'][0](data_get($blog, $column['field'])) }}
                  @endif
                @elseif(array_key_exists("custom", $column) && isset($column["custom"]))
                  @if ($column['field'] == 'status')
                    <x-ui.status type="{{ data_get($transaction, $column['field']) }}">
                      {{ ucfirst(data_get($transaction, $column['field'])) }}</x-ui.status>
                  @endif
                @else
                  {{ data_get($blog, $column['field']) }}
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
          <span class="font-medium">{{ $blogs->firstItem() }}</span>
          to
          <span class="font-medium">{{ $blogs->lastItem() }}</span>
          of
          <span class="font-medium">{{ $blogs->total() }}</span>
          results
        </p>
      </div>
      <div class="inline-block">
        {{ $blogs->links() }}
      </div>
    </div>
    </div>
    <x-jet-dialog-modal wire:model="modalVisible">
      <x-slot name="title">
        Delete Blog
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
          <x-ui.loading-indicator wire:target="delete" />
        </x-jet-danger-button>
      </x-slot>
    </x-jet-dialog-modal>
  </x-slot>
</x-ui.table>
