<x-layout.admin>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('admin.promocodes.show',$promocode) }}
    </x-slot>
    <livewire:admin.promocode.promocode-show :model="$promocode" />

</x-layout.admin>