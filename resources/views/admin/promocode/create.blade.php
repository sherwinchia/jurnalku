<x-layout.admin>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('admin.promocodes.create') }}
    </x-slot>
    <livewire:admin.promocode.promocode-form />
</x-layout.admin>