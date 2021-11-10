@if ($sortField !== $field)
<x-icon.sort-descending class="inline-block w-4 h-4" wire:loading.remove />
@elseif($sortAsc)
<x-icon.sort-ascending class="inline-block w-4 h-4" wire:loading.remove />
@else
<x-icon.sort-descending class="inline-block w-4 h-4" wire:loading.remove />
@endif

<span wire:loading wire:target="sortBy('{{ $field }}')"
    class="w-3 h-3 ml-2 border-t-2 border-b-2 border-black rounded-full animate-spin">
</span>