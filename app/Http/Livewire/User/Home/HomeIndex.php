<?php

namespace App\Http\Livewire\User\Home;

use App\Models\Trade;
use App\Models\Portfolio;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Component;

class HomeIndex extends Component
{
    public $portfolios = [];
    public $trades = [];
    public $performance = [
        'win' => null,
        'lose' => null
    ];

    public function loadData()
    {
        $this->portfolios = current_user()->portfolios;

        $this->trades = current_user()->trades()->latest()->take(10)->get();

        $this->performance = [
            'win' => current_user()->total_win,
            'lose' => current_user()->total_lose,
        ];
    }

    public function render()
    {
        return view('livewire.user.home.home-index', []);
    }
}
