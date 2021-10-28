<x-layout.admin>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('admin.packages.edit', $package) }}
    </x-slot>
    <livewire:admin.package.package-form :model="$package" />
</x-layout.admin>