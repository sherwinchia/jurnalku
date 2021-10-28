<x-layout.admin>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('admin.transactions.create') }}
    </x-slot>
    <div class="flex-1 flex flex-col p-8">
        <livewire:admin.form.transaction-form />
    </div>
</x-layout.admin>