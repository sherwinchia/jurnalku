<?php

namespace App\Http\Livewire\User\Home;

use App\Models\Trade;
use App\Models\Portfolio;
use App\Services\TradeAnalyticsService;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Livewire\Component;

class HomeIndex extends Component
{
    public Portfolio $portfolio;
    public $portfolios;
    public $trades;

    public function mount()
    {
        // $this->portfolios = current_user()->portfolios->load('trades');
        $this->trades = current_user()->trades()->latest()->take(10)->get();
        // dd($this->trades);
        // $this->portfolio = $this->portfolios->first();
        // dd($this->portfolio);
    }

    public function initData()
    {
    }

    public function loadData()
    {
    }

    public function render()
    {
        return view('livewire.user.home.home-index', []);
    }
}
