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
      <div class="flex flex-wrap gap-1">
        <button wire:click="changeFilter('7D')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none flex items-center {{ $filter == '7D' ? 'border-primary-500' : '' }}">
          <span wire:loading.remove wire:target="changeFilter('7D')">7D</span>
          <span wire:loading wire:target="changeFilter('7D')"
            class="w-4 h-4 border-t-2 border-b-2 border-gray-700 rounded-full animate-spin">
          </span>
        </button>
        <button wire:click="changeFilter('1M')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none flex items-center {{ $filter == '1M' ? 'border-primary-500' : '' }}">
          <span wire:loading.remove wire:target="changeFilter('1M')">1M</span>
          <span wire:loading wire:target="changeFilter('1M')"
            class="w-4 h-4 border-t-2 border-b-2 border-gray-700 rounded-full animate-spin">
          </span>
        </button>
        <button wire:click="changeFilter('3M')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none flex items-center {{ $filter == '3M' ? 'border-primary-500' : '' }}">
          <span wire:loading.remove wire:target="changeFilter('3M')">3M</span>
          <span wire:loading wire:target="changeFilter('3M')"
            class="w-4 h-4 border-t-2 border-b-2 border-gray-700 rounded-full animate-spin">
          </span>
        </button>
        <button wire:click="changeFilter('6M')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none flex items-center {{ $filter == '6M' ? 'border-primary-500' : '' }}">
          <span wire:loading.remove wire:target="changeFilter('6M')">6M</span>
          <span wire:loading wire:target="changeFilter('6M')"
            class="w-4 h-4 border-t-2 border-b-2 border-gray-700 rounded-full animate-spin">
          </span>
        </button>
        <button wire:click="changeFilter('1Y')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none flex items-center {{ $filter == '1Y' ? 'border-primary-500' : '' }}">
          <span wire:loading.remove wire:target="changeFilter('1Y')">1Y</span>
          <span wire:loading wire:target="changeFilter('1Y')"
            class="w-4 h-4 border-t-2 border-b-2 border-gray-700 rounded-full animate-spin">
          </span>
        </button>
        <button wire:click="changeFilter('2Y')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none flex items-center {{ $filter == '2Y' ? 'border-primary-500' : '' }}">
          <span wire:loading.remove wire:target="changeFilter('2Y')">2Y</span>
          <span wire:loading wire:target="changeFilter('2Y')"
            class="w-4 h-4 border-t-2 border-b-2 border-gray-700 rounded-full animate-spin">
          </span>
        </button>
        <button wire:click="changeFilter('3Y')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none flex items-center {{ $filter == '3Y' ? 'border-primary-500' : '' }}">
          <span wire:loading.remove wire:target="changeFilter('3Y')">3Y</span>
          <span wire:loading wire:target="changeFilter('3Y')"
            class="w-4 h-4 border-t-2 border-b-2 border-gray-700 rounded-full animate-spin">
          </span>
        </button>
        <button wire:click="changeFilter('All')"
          class="px-3 py-1 border border-gray-300 rounded-md focus:outline-none flex items-center {{ $filter == 'All' ? 'border-primary-500' : '' }}">
          <span wire:loading.remove wire:target="changeFilter('All')">All</span>
          <span wire:loading wire:target="changeFilter('All')"
            class="w-4 h-4 border-t-2 border-b-2 border-gray-700 rounded-full animate-spin">
          </span>
        </button>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 gap-2 lg:grid-cols-4 lg:gap-6" wire:init="initData">
    <div class="grid grid-cols-1 gap-2 col-span-full lg:col-span-3 lg:grid-cols-3 lg:gap-6">
      <div class="grid grid-cols-1 gap-2 col-span-full lg:grid-cols-3 lg:gap-6">
        <x-ui.card class="p-4 ">
          <x-ui.header class="pb-4 font-medium">
            Total Net Profit
          </x-ui.header>
          @if (isset($essentialsData['net_profit']))
            <span
              class="font-medium {{ text_color($essentialsData['net_profit']) }}">{{ decimal_to_human($essentialsData['net_profit'], $currency, false) }}</span>
          @endif
        </x-ui.card>
        <x-ui.card class="p-4 ">
          <x-ui.header class="pb-4 font-medium">
            Average Trade Net Profit
          </x-ui.header>
          @if (isset($essentialsData['average_trade_net_profit']))
            <span
              class="font-medium {{ text_color($essentialsData['average_trade_net_profit']) }}">{{ decimal_to_human($essentialsData['average_trade_net_profit'], $currency, false, 2) }}</span>
          @endif
        </x-ui.card>
        <x-ui.card class="p-4 ">
          <x-ui.header class="pb-4 font-medium">
            Profit Factor
          </x-ui.header>
          @if (isset($essentialsData['profit_factor']))
            <span
              class="font-medium {{ text_color($essentialsData['profit_factor']) }}">{{ decimal_to_human($essentialsData['profit_factor'], '', false, 2) }}</span>
          @endif
        </x-ui.card>
      </div>

      <div class=" col-span-full lg:col-span-2">
        <x-ui.card class="col-span-2 p-4">
          <x-ui.header class="pb-4 font-medium">
            Recent trades
          </x-ui.header>

          <x-ui.table>
            <thead>
              <x-ui.table-row>
                <x-ui.table-header>
                  Instrument
                </x-ui.table-header>
                <x-ui.table-header class="text-center">
                  Quantity
                </x-ui.table-header>
                <x-ui.table-header class="text-center">
                  Entry Date
                </x-ui.table-header>
                <x-ui.table-header class="text-center">
                  Entry Price
                </x-ui.table-header>
                <x-ui.table-header class="text-center">
                  Return
                </x-ui.table-header>
                <x-ui.table-header class="text-center">
                  Action
                </x-ui.table-header>
              </x-ui.table-row>
            </thead>
            <tbody>
              @foreach ($recentTrades as $trade)
                <x-ui.table-row>
                  <x-ui.table-data>
                    {{ $trade->instrument }}
                  </x-ui.table-data>
                  <x-ui.table-data class="text-center">
                    {{ decimal_to_human($trade->quantity) }}
                  </x-ui.table-data>
                  <x-ui.table-data class="text-center">
                    {{ date_to_human($trade->entry_date, 'd/m/Y') }}
                  </x-ui.table-data>
                  <x-ui.table-data class="text-center">
                    {{ decimal_to_human($trade->entry_price, $portfolio->currency) }}
                  </x-ui.table-data>
                  <x-ui.table-data
                    class="{{ isset($trade->return) ? ($trade->return > 0 ? 'text-green-500' : 'text-red-500') : '-' }} text-center">
                    {{ isset($trade->exit_date) ? decimal_to_human($trade->return, $portfolio->currency) : '-' }}
                  </x-ui.table-data>
                  <x-ui.table-data class="text-center">
                    <a class="" role="button" href="{{ route('user.trades.show', $trade->id) }}">
                      <x-icon.eye class="w-4 h-4 mx-auto " />
                    </a>
                  </x-ui.table-data>
                </x-ui.table-row>
              @endforeach
            </tbody>
          </x-ui.table>
        </x-ui.card>
      </div>

      <div class="flex flex-col space-y-2 col-span-full lg:col-span-1 lg:space-y-6">
        <x-ui.card class="col-span-2 p-4">
          <x-ui.header class="pb-4 font-medium">
            Total Trade
          </x-ui.header>
          @if (isset($essentialsData['trade_count']))
            <span class="font-medium">{{ decimal_to_human($essentialsData['trade_count'], '', false) }}</span>
          @endif
        </x-ui.card>
        <x-ui.card class="flex flex-col col-span-2 p-4 space-y-2 text-sm">
          <x-ui.header class="pb-2 font-medium">
            Biggest Winner/Loser
          </x-ui.header>
          @if (isset($bestTradeReturn) && isset($worstTradeReturn))
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

        <x-ui.card class="flex flex-col col-span-2 p-4 space-y-2 text-sm">
          <x-ui.header class="pb-2 font-medium">
            Longest Streaks
          </x-ui.header>
          @if (isset($essentialsData))
            <div class="flex justify-between">
              <span>Win</span>
              <span class="font-medium text-green-400">{{ $essentialsData['longest_win_streaks'] }}</span>
            </div>
            <div class="flex justify-between">
              <span>Lose</span>
              <span class="font-medium text-red-400">{{ $essentialsData['longest_lose_streaks'] }}</span>
            </div>
          @endif
        </x-ui.card>

        <x-ui.card class="flex flex-col col-span-2 p-4 space-y-2 text-sm">
          <x-ui.header class="pb-2 font-medium">
            Average Winner
          </x-ui.header>
          @if (isset($essentialsData))
            <div class="flex justify-between">
              <span>Win</span>
              <span
                class="font-medium text-green-400">{{ decimal_to_human($essentialsData['average_winner'], $currency, false, 2) }}</span>
            </div>
            <div class="flex justify-between">
              <span>Lose</span>
              <span
                class="font-medium text-red-400">{{ decimal_to_human($essentialsData['average_loser'], $currency, false, 2) }}</span>
            </div>
          @endif
        </x-ui.card>
      </div>
    </div>
    <div class="flex flex-col col-span-1 space-y-2 lg:space-y-6">
      <x-ui.card class="p-4 " wire:ignore>
        <x-ui.header class="pb-4 font-medium">
          Net Profit
        </x-ui.header>
        <canvas id="netProfitChart"></canvas>
      </x-ui.card>

      <x-ui.card class="p-4 pb-16 " style="height:40vh;" wire:ignore>
        <x-ui.header class="pb-4 font-medium">
          Win Ratio
        </x-ui.header>
        <canvas class="p-8" id="winLoseChart"></canvas>
      </x-ui.card>
    </div>
  </div>
  <x-ui.loading />
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
          maintainAspectRatio: false,
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
        netProfitChart.data.labels = []
        netProfitChart.data.datasets[0].data = netProfitData;

        netProfitChart.data.datasets[0].backgroundColor = netProfitData.map((value) => value.y > 0 ?
          fullConfig.theme.colors.green[400] : fullConfig.theme.colors.red[400]);
        netProfitChart.update();

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
