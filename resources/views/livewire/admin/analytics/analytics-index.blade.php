<div class="grid grid-cols-1 gap-2 lg:grid-cols-6 lg:gap-6" wire:init="initData">
  {{-- Total Users --}}
  <x-ui.card class="flex items-center justify-between col-span-2 p-4">
    <div class="flex flex-col">
      <x-ui.header class="pb-4 font-medium">
        Total Users
      </x-ui.header>
      @if ($usersData)
        <span class="font-medium ">{{ $usersData['total_users'] }}
          @if ($usersData['new_users'] > 0)
            <span class="text-green-400">(+{{ $usersData['new_users'] }})</span>
          @endif
        </span>
      @endif
    </div>

    <x-icon.user class="w-16 h-16 text-primary-500"></x-icon.user>
  </x-ui.card>

  {{-- Total Transations --}}
  <x-ui.card class="flex items-center justify-between col-span-2 p-4">
    <div class="flex flex-col">
      <x-ui.header class="pb-4 font-medium">
        Total Transactions
      </x-ui.header>
      @if ($transactionsData)
        <span class="font-medium ">{{ $transactionsData['total_transactions'] }}
          @if ($transactionsData['new_transactions'] > 0)
            <span class="text-green-400">(+{{ $transactionsData['new_transactions'] }})</span>
          @endif
        </span>
      @endif
    </div>
    <x-icon.credit-card class="w-16 h-16 text-primary-500"></x-icon.credit-card>
  </x-ui.card>

  {{-- Total Revenue --}}
  <x-ui.card class="flex items-center justify-between col-span-2 p-4">
    <div class="flex flex-col">
      <x-ui.header class="pb-4 font-medium">
        Total Revenue
      </x-ui.header>
      @if ($totalRevenue)
        <span class="font-medium ">{{ decimal_to_human($totalRevenue, 'Rp') }}</span>
      @endif
    </div>
    <x-icon.currency-dollar class="w-16 h-16 text-primary-500"></x-icon.currency-dollar>
  </x-ui.card>

  {{-- Revenue Chart --}}
  <x-ui.card class="p-4 pb-10 col-span-full h-96">
    <x-ui.header class="pb-4 font-medium">
      Revenue Chart
    </x-ui.header>
    <canvas id="revenueChart"></canvas>
  </x-ui.card>

  {{-- Recent Registered User --}}
  <x-ui.card class="col-span-3 p-4">
    <x-ui.header class="pb-4 font-medium">
      Recent User
    </x-ui.header>
    <div class="flex flex-col space-y-2">
      @if ($usersData)
        @foreach ($usersData['latest_users'] as $key => $user)
          <a href="{{ route('admin.users.show', $user->id) }}">
            <x-ui.card class="flex p-4 card">
              <span class="pr-2">{{ $key }}.</span>
              <span>{{ $user->name }}</span>
            </x-ui.card>
          </a>
        @endforeach
      @endif
    </div>
  </x-ui.card>

  {{-- Recent Transactions --}}
  <x-ui.card class="col-span-3 p-4">
    <x-ui.header class="pb-4 font-medium">
      Recent Transactions
    </x-ui.header>
    <div class="flex flex-col space-y-2">
      @if ($transactionsData)
        @foreach ($transactionsData['latest_transactions'] as $key => $transaction)
          <a href="{{ route('admin.transactions.show', $transaction->id) }}">
            <x-ui.card class="flex p-4 card">
              <span class="pr-2">{{ $key }}.</span>
              <div class="flex justify-between flex-1">
                <span>{{ $transaction->merchant_ref }}</span>
                <span>{{ decimal_to_human($transaction->net_total, 'Rp') }}</span>
              </div>
            </x-ui.card>
          </a>
        @endforeach
      @endif
    </div>
  </x-ui.card>
  <x-ui.loading />
  <script type="text/javascript">
    document.addEventListener('livewire:load', function() {
      const revenueCanvas = document.getElementById('revenueChart');
      const revenueChart = new Chart(revenueCanvas, {
        type: 'bar',
        data: {
          datasets: [{
            label: 'Net profit',
            data: null,
            borderWidth: 1,
            backgroundColor: fullConfig.theme.colors.green[400]
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
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

      Livewire.on('updateData', () => {
        let revenueData = @this.revenueData;
        revenueChart.data.labels = []
        revenueChart.data.datasets[0].data = revenueData;
        revenueChart.update();
      })
    })
  </script>
</div>
