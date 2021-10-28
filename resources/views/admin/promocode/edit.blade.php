<x-layout.admin>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('admin.promocodes.edit', $promocode) }}
    </x-slot>
    <livewire:admin.promocode.promocode-form :model="$promocode" />

</x-layout.admin>