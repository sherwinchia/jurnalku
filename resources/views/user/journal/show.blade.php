<x-layout.user >
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('user.trades.show', $trade) }}
    </x-slot>
    <livewire:user.journal.trade-show :trade="$trade"/>
</x-layout.user>
