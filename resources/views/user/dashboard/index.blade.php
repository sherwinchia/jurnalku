<x-layout.user header="Home">
    @if (!current_user()->portfolios->isEmpty())
      <livewire:user.analytics.analytics-index />
      @else
      <span class="text-lg text-semibold">No portfolio available.</span>
    @endif

</x-layout.user>
