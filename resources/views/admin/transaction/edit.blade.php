<x-layout.admin>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('admin.transactions.edit', $transaction) }}
    </x-slot>
    <livewire:admin.form.transaction-form :model="$transaction" />

</x-layout.admin>