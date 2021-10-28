<x-layout.admin>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('admin.users.edit', $user) }}
    </x-slot>
    <livewire:admin.user.user-form :model="$user" />
</x-layout.admin>