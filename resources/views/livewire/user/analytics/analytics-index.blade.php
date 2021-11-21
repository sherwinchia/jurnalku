<div>
  <div class="pb-4">
    <x-ui.select wire:model="selectedPortfolio" wire:change="changePortfolio">
      @foreach ($portfolios as $portfolio)
        <option value="{{ $portfolio->id }}">{{ $portfolio->name }}</option>
      @endforeach
    </x-ui.select>
  </div>
  <div class="grid grid-cols-1 gap-0 lg:gap-6 lg:grid-cols-6 xl:grid-cols-8" wire:init="initData">
    <div
      class="grid content-start grid-cols-1 gap-6 pb-6 lg:col-span-4 xl:col-span-6 sm:grid-cols-2 lg:grid-cols-6 lg:pb-0">
      <x-ui.card class="col-span-3 p-4 pb-16" style="" wire:ignore>
        <span class="pb-4">Net Profit</span>
        <canvas id="netProfitChart"></canvas>
      </x-ui.card>
      <x-ui.card class="col-span-3 p-4 pb-16" style="" wire:ignore>
        <span class="pb-4">Balance Growth</span>
        <canvas id="balanceGrowthChart"></canvas>
      </x-ui.card>
    </div>

    <div class="grid content-start grid-cols-1 gap-6 lg:col-span-2 xl:col-span-2">
      <x-ui.card class="p-4" wire:ignore>
        <span class="pb-4">Win/Lose</span>
        <canvas class="p-8" id="winLoseChart"></canvas>
      </x-ui.card>
      <x-ui.card class="p-4"></x-ui.card>
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
