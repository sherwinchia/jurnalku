<div class="grid grid-cols-1 gap-0 lg:gap-6 lg:grid-cols-6 xl:grid-cols-8" wire:init="initData">
  <div
    class="grid content-start grid-cols-1 gap-6 pb-6 lg:col-span-4 xl:col-span-6 sm:grid-cols-2 lg:grid-cols-3 lg:pb-0">
    <x-ui.card class="col-span-3 p-4 pb-16" style="height: 50vh;" wire:ignore>
      <div class="flex items-center space-x-4">
        <x-ui.select wire:model="selectedPortfolio" wire:change="changePortfolio">
          @foreach ($portfolios as $portfolio)
            <option value="{{ $portfolio->id }}">{{ $portfolio->name }}</option>
          @endforeach
        </x-ui.select>
        <span>Growth Chart</span>
      </div>
      <canvas id="performanceChart"></canvas>
    </x-ui.card>
    {{-- <x-ui.card class="col-span-1 p-4 bg-blue-200">
      Profit Calendar
    </x-ui.card>
    <x-ui.card class="col-span-2 p-4 bg-blue-200">
      Win Loss
    </x-ui.card> --}}
  </div>

  <div class="grid grid-cols-1 gap-6 lg:col-span-2 xl:col-span-2">
    <x-ui.card class="p-4">
      <h2>{{ current_user()->name }}</h2>
      @if (current_user()->subscription_active)
        <p class="text-sm text-gray-400">Active until
          {{ date_to_human(current_user()->subscription->expired_at, 'd M Y') }}</p>
        <p class="text-sm text-gray-400">Max portfolio {{ current_user()->max_portfolio }}</p>
      @else
        <p class="text-sm text-gray-400">Account inactive</p>
      @endif
    </x-ui.card>
    @if (isset($portfolios) && !$portfolios->isEmpty())
      <x-ui.card class="p-4">
        <div class="pb-2 font-medium">Portfolio</div>
        <div class="flex flex-col space-y-2">
          @foreach ($portfolios as $portfolio)
            <a href="{{ route('user.portfolios.show', $portfolio->id) }}">
              <x-ui.card class="p-4">
                <div class="flex items-center justify-between">
                  <span class="tracking-widest ">{{ $portfolio->name }}</span>
                  <div class="flex flex-col items-end justify-end">
                    <span
                      class="text-sm">{{ decimal_to_human($portfolio->analytics->getBalanceGrowth(), $portfolio->currency) }}
                    </span>
                    <span
                      class="flex items-center {{ $portfolio->analytics->getBalanceGrowthPercentage() != 0 ? ($portfolio->analytics->getBalanceGrowthPercentage() > 0 ? 'text-green-500' : 'text-red-500') : '' }}">
                      <span
                        class="text-xs">{{ decimal_to_human($portfolio->analytics->getBalanceGrowthPercentage(), null, true) }}</span>
                      @if ($portfolio->analytics->getBalanceGrowthPercentage() > 0)
                        <x-icon.chevron-up class="w-4 h-4" />
                      @elseif($portfolio->analytics->getBalanceGrowthPercentage()
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
    @endif
    @if (isset($trades) && !$trades->isEmpty())
      <x-ui.card class="p-4">
        <div class="pb-2 font-medium">Recent Trades</div>
        <div class="flex flex-col space-y-2 overflow-y-auto h-96 ">
          @foreach ($trades as $trade)
            <a href="{{ route('user.trades.show', $trade->id) }}">
              <x-ui.card class="flex items-center justify-between p-4">
                <div class="flex items-center justify-between space-x-2">
                  <span class="text-sm">{{ $trade->instrument }}</span>
                  <span class="text-xs">{{ date_to_human($trade->entry_date, 'd/m/y') }}</span>
                </div>
                <x-ui.status type="{{ $trade->status }}">{{ ucfirst($trade->status) }}</x-ui.status>
              </x-ui.card>
            </a>
          @endforeach
        </div>
      </x-ui.card>
    @endif
  </div>

  <script type="text/javascript">
    document.addEventListener('livewire:load', function() {
      const ctx = document.getElementById('performanceChart');
      const performanceChart = new Chart(ctx, {
        type: 'line',
        data: {
          datasets: [{
            label: 'Balance Growth (%)',
            data: @this.performanceData,
            backgroundColor: [
              fullConfig.theme.colors.primary[500],
            ],
            borderWidth: 3,
            fill: false
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true
            }
          },
        }
      });

      Livewire.on('changeData', () => {
        performanceChart.data.datasets[0].data = @this.chartData;
        performanceChart.update();
      })
    })
  </script>
</div>
