<?php

namespace App\Http\Livewire\User\Home;

use App\Models\Trade;
use App\Models\Portfolio;
use App\Services\TradeAnalyticsService;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Component;

class HomeIndex extends Component
{
    public $portfolios;
    public $trades;
    public $data = [
        [
            'x' => 'Abigail',
            'y' => 5
        ],
        [
            'x' => 'Lucy',
            'y' => 10
        ],
    ];

    public function mount()
    {
    }


    public function changeData()
    {
        $this->data =
            [
                [
                    'x' => 'Abigail',
                    'y' => 12
                ],
                [
                    'x' => 'Lucy',
                    'y' => 1
                ],
            ];

        $this->emit('changeData');
    }

    public function loadData()
    {
        $this->portfolios = current_user()->portfolios;

        $this->trades = current_user()->trades()->latest()->take(10)->get();

        $this->performance = [];
    }

    public function render()
    {
        return view('livewire.user.home.home-index', []);
    }
}
