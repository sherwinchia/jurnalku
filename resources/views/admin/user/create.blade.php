<x-layout.admin>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('admin.users.create') }}
    </x-slot>
    <livewire:admin.user.user-form />
</x-layout.admin>