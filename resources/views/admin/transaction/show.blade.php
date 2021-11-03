<x-layout.admin>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('admin.transactions.show', $transaction) }}
    </x-slot>
    <livewire:admin.transaction.transaction-show :transaction="$transaction" />
</x-layout.admin>
