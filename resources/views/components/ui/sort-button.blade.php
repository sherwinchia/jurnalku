<button {{ $attributes->merge(['class'=>'flex items-center gap-x-1 focus:outline-none uppercase' ]) }}
    wire:loading.attr="disabled">
    {{ $slot }}
    @if ($sortField !== $targetField)
    <x-icon.sort-descending class="inline-block w-4 h-4" wire:loading.remove
        wire:target="sortBy('{{ $targetField }}')" />
    @elseif($sortAsc)
    <x-icon.sort-ascending class="inline-block w-4 h-4" wire:loading.remove
        wire:target="sortBy('{{ $targetField }}')" />
    @else
    <x-icon.sort-descending class="inline-block w-4 h-4" wire:loading.remove
        wire:target="sortBy('{{ $targetField }}')" />
    @endif

    <x-ui.loading-indicator wire:target="sortBy('{{ $targetField }}')" />
    
</button>