<div>
  <div class="flex items-start pb-4 space-x-4">
    <div class="flex flex-col space-y-2">
      <span class="text-sm font-medium">Portfolio</span>
      <x-ui.select wire:model="selectedPortfolio" wire:change="changePortfolio">
        @foreach ($portfolios as $portfolio)
          <option value="{{ $portfolio->id }}">{{ $portfolio->name }}</option>
        @endforeach
      </x-ui.select>
    </div>
    <div class="flex flex-col space-y-2">
      <span class="text-sm font-medium">Filter</span>
      <div>
        <button wire:click="changeFilter('7D')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none {{ $filter == '7D' ? 'border-primary-500' : '' }}"
          href="">7D</button>
        <button wire:click="changeFilter('1M')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none {{ $filter == '1M' ? 'border-primary-500' : '' }}"
          href="">1M</button>
        <button wire:click="changeFilter('3M')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none {{ $filter == '3M' ? 'border-primary-500' : '' }}"
          href="">3M</button>
        <button wire:click="changeFilter('6M')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none {{ $filter == '6M' ? 'border-primary-500' : '' }}"
          href="">6M</button>
        <button wire:click="changeFilter('1Y')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none {{ $filter == '1Y' ? 'border-primary-500' : '' }}"
          href="">1Y</button>
        <button wire:click="changeFilter('2Y')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none {{ $filter == '2Y' ? 'border-primary-500' : '' }}"
          href="">2Y</button>
        <button wire:click="changeFilter('3Y')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none {{ $filter == '3Y' ? 'border-primary-500' : '' }}"
          href="">3Y</button>
        <button wire:click="changeFilter('All')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none {{ $filter == 'All' ? 'border-primary-500' : '' }}"
          href="">All</button>
      </div>
    </div>
  </div>
  <div class="grid grid-cols-8 pb-6 lg:gap-6">
    @if ($essentialsData)
      <x-ui.card class="col-span-2 p-4">
        <x-ui.header class="pb-4 font-medium">Net Profit</x-ui.header>
        <span
          class="font-medium {{ $essentialsData['net_profit'] > 0 ? 'text-green-400' : 'text-red-400' }}">{{ decimal_to_human($essentialsData['net_profit'], $currency, false) }}</span>
      </x-ui.card>
      <x-ui.card class="col-span-2 p-4">
        <x-ui.header class="pb-4 font-medium">Average Trade Net Profit</x-ui.header>
        <span
          class="font-medium {{ $essentialsData['average_trade_net_profit'] > 0 ? 'text-green-400' : 'text-red-400' }}">{{ decimal_to_human($essentialsData['average_trade_net_profit'], $currency, false, 2) }}</span>
      </x-ui.card>
      <x-ui.card class="col-span-2 p-4">
        <x-ui.header class="pb-4 font-medium">Profit Factor</x-ui.header>
        <span class="font-medium">{{ decimal_to_human($essentialsData['profit_factor'], '', false, 2) }}</span>
      </x-ui.card>
      <x-ui.card class="col-span-2 p-4">
        <x-ui.header class="pb-4 font-medium">Total Trade</x-ui.header>
        <span class="font-medium">{{ decimal_to_human($essentialsData['trade_count'], '', false) }}</span>
      </x-ui.card>

    @endif
  </div>

  <div class="grid grid-cols-1 gap-0 lg:gap-6 lg:grid-cols-6 xl:grid-cols-8" wire:init="initData">
    <div
      class="grid content-start grid-cols-1 gap-6 pb-6 lg:col-span-4 xl:col-span-6 sm:grid-cols-2 lg:grid-cols-6 lg:pb-0">
      <x-ui.card class="col-span-3 p-4 pb-16" style="" wire:ignore>
        <x-ui.header class="pb-4 font-medium">Net Profit</x-ui.header>
        <canvas id="netProfitChart"></canvas>
      </x-ui.card>
      <x-ui.card class="col-span-3 p-4 pb-16" style="" wire:ignore>
        <x-ui.header class="pb-4 font-medium">Balance Growth</x-ui.header>
        <canvas id="balanceGrowthChart"></canvas>
      </x-ui.card>
    </div>

    <div class="grid content-start grid-cols-1 gap-6 lg:col-span-2 xl:col-span-2">
      <x-ui.card class="col-span-2 p-4" wire:ignore>
        <x-ui.header class="pb-4 font-medium">Win/Lose</x-ui.header>
        <canvas class="p-8" id="winLoseChart"></canvas>
      </x-ui.card>
      <x-ui.card class="flex flex-col col-span-2 p-4 space-y-2 text-sm">
        @if (isset($bestTradeReturn) && isset($worstTradeReturn))
          <x-ui.header class="pb-2 font-medium">Best/Worst Trade Return</x-ui.header>
          <a href="{{ route('user.trades.show', $bestTradeReturn->id) }}">
            <x-ui.card class="flex justify-between p-4">
              <span>{{ $bestTradeReturn->instrument }}</span>
              <span class="text-green-400">{{ decimal_to_human($bestTradeReturn->return, $currency) }}</span>
            </x-ui.card>
          </a>
          <a href="{{ route('user.trades.show', $worstTradeReturn->id) }}">
            <x-ui.card class="flex justify-between p-4">
              <span>{{ $worstTradeReturn->instrument }}</span>
              <span class="text-red-400">{{ decimal_to_human($worstTradeReturn->return, $currency) }}</span>
            </x-ui.card>
          </a>
        @endif
      </x-ui.card>


    </div>
  </div>

  <script type="text/javascript">
    document.addEventListener('livewire:load', function() {
      const netProfitCanvas = document.getElementById('netProfitChart');
      const netProfitChart = new Chart(netProfitCanvas, {
        type: 'bar',
        data: {
          datasets: [{
            label: 'Net profit',
            data: null,
            borderWidth: 1,
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                display: false
              }
            },
            x: {
              grid: {
                display: false
              }
            }
          },
          plugins: {
            legend: {
              display: false
            },
          }
        }
      });

      const balanceGrowthCanvas = document.getElementById('balanceGrowthChart');
      const balanceGrowthChart = new Chart(balanceGrowthCanvas, {
        type: 'bar',
        data: {
          datasets: [{
            label: 'Balance Growth (%)',
            data: null,
            borderWidth: 1,
            fill: true
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          scales: {
            y: {
              beginAtZero: true,
              grid: {
                display: false
              }
            },
            x: {
              grid: {
                display: false
              }
            }

          },
          plugins: {
            legend: {
              display: false
            },
          }
        }
      });

      const winLoseCanvas = document.getElementById('winLoseChart');
      const winLoseChart = new Chart(winLoseCanvas, {
        type: 'pie',
        data: {
          datasets: [{
            label: 'Win/Loss',
            data: null,
            hoverOffset: 4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          scales: {
            y: {
              beginAtZero: true,
              display: false
            },
            x: {
              display: false
            }
          },
          plugins: {
            legend: {
              display: false
            },
          }
        }
      });

      Livewire.on('updateData', () => {

        let netProfitData = @this.netProfitData;
        netProfitChart.data.datasets[0].data = netProfitData;
        netProfitChart.data.datasets[0].backgroundColor = netProfitData.map((value) => value.y > 0 ?
          fullConfig.theme.colors.green[400] : fullConfig.theme.colors.red[400]);
        netProfitChart.update();

        let balanceGrowthData = @this.balanceGrowthData;
        balanceGrowthChart.data.datasets[0].data = balanceGrowthData;
        balanceGrowthChart.data.datasets[0].backgroundColor = balanceGrowthData.map((value) => value.y > 0 ?
          fullConfig.theme.colors.green[400] : fullConfig.theme.colors.red[400]);
        balanceGrowthChart.update();

        let winLoseData = @this.winLoseData;
        winLoseChart.data.datasets[0].backgroundColor = [fullConfig.theme.colors.green[400], fullConfig.theme
          .colors.red[400]
        ];
        winLoseChart.data.datasets[0].data = winLoseData;
        winLoseChart.data.labels = ['Win', 'Lose'];
        winLoseChart.update();
      })
    })
  </script>
</div>
