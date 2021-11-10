@if ($sortField !== $field)
    <x-icon.sort-descending class="inline-block w-4 h-4" wire:loading.remove/>
@elseif($sortAsc)
    <x-icon.sort-ascending class="inline-block w-4 h-4" wire:loading.remove/>
@else
    <x-icon.sort-descending class="inline-block w-4 h-4" wire:loading.remove/>
@endif
