@if ($sortField !== $field)
    <x-icon.sort-descending class="w-4 h-4 inline-block"/>
@elseif($sortAsc)
    <x-icon.sort-ascending class="w-4 h-4 inline-block"/>
@else
    <x-icon.sort-descending class="w-4 h-4 inline-block"/>
@endif
