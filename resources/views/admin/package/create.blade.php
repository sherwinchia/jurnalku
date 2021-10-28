<x-layout.admin>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('admin.packages.create') }}
    </x-slot>
    <livewire:admin.package.package-form />
</x-layout.admin>