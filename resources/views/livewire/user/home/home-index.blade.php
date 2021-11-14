<div class="grid grid-cols-1 gap-8 mt-6 sm:grid-cols-2 lg:grid-cols-3" wire:init="loadData">
  <x-ui.card class="col-span-3 p-4 ">
    Performance Chart
  </x-ui.card>
  <x-ui.card class="col-span-1 p-4 bg-blue-200">
    Profit Calendar
  </x-ui.card>
  <x-ui.card class="col-span-2 p-4 bg-blue-200">
    Win Loss
    <div>{{ $performance['win'] }}</div>
    <div>{{ $performance['lose'] }}</div>
  </x-ui.card>
  <x-ui.card class="col-span-1 p-4">
    Portfolio
    <div class="flex flex-col space-y-2">
      @foreach ($portfolios as $portfolio)
        <a href="{{ route('user.portfolios.show', $portfolio->id) }}">
          <x-ui.card class="p-4">
            <div class="flex items-center justify-between">
              <span class="text-xl tracking-widest">{{ $portfolio->name }}</span>
              <div class="flex flex-col items-center justify-end">
                <span
                  class="">{{ decimal_to_human($portfolio->calculate_balance, $portfolio->currency) }}
                </span>
                <span
                  class="flex items-center {{ $portfolio->calculate_growth_percentage != 0 ? ($portfolio->calculate_growth_percentage > 0 ? 'text-green-500' : 'text-red-500') : '' }}">
                  <span
                    class="text-sm">{{ decimal_to_human($portfolio->calculate_growth_percentage, null, true) }}</span>
                  @if ($portfolio->calculate_growth_percentage > 0)
                    <x-icon.chevron-up class="w-4 h-4" />
                  @elseif($portfolio->calculate_growth_percentage
                    < 0) <x-icon.chevron-down class="w-4 h-4" />
                  @endif
                </span>
              </div>
            </div>
          </x-ui.card>
        </a>
      @endforeach
    </div>
  </x-ui.card>
  <x-ui.card class="col-span-1 p-4 overflow-y-auto">
    Recent Trade
    <div class="flex flex-col space-y-2">
      @foreach ($trades as $trade)
        <a href="{{ route('user.trades.show', $trade->id) }}">
          <x-ui.card class="flex items-center justify-between p-4">
            <div class="grid grid-cols-4 gap-x-2">
              <span class="col-span-1">{{ $trade->instrument }}</span>
              <span class="col-span-3">{{ date_to_human($trade->entry_date) }}</span>
            </div>
            <x-ui.status type="{{ $trade->status }}">{{ ucfirst($trade->status) }}</x-ui.status>
          </x-ui.card>
        </a>
      @endforeach
    </div>
  </x-ui.card>
  <script>

  </script>
</div>
