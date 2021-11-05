<x-layout.user>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('user.portfolios.show', $portfolio) }}
    </x-slot>
    <livewire:user.portfolio.portfolio-show :portfolio="$portfolio"/>
</x-layout.user>
