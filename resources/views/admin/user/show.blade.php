<x-layout.admin>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('admin.users.show', $user) }}
    </x-slot>
    <livewire:admin.user.user-show :user="$user" />
</x-layout.admin>
