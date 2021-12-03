<x-layout.user header="Home">
    @if (!current_user()->portfolios->isEmpty())
      <livewire:user.analytics.analytics-index />
      @else
      <x-ui.header>No portfolio available.</x-ui.header>
    @endif

</x-layout.user>
