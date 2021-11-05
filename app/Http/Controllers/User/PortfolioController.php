<?php

namespace App\Http\Controllers\User;

use App\Exports\PortfolioExport;
use App\Http\Controllers\Controller;
use App\Http\Traits\Alert;
use App\Models\Portfolio;
use App\Models\Trade;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PortfolioController extends Controller
{
    use AuthorizesRequests, Alert;

    const PATH = "user.portfolio.";

    public function index()
    {
        return view(self::PATH . 'index');
    }

    public function show(Portfolio $portfolio)
    {
        try {
            $this->authorize('manage-portfolio', $portfolio);
        } catch (\Exception $e) {
            $this->altAlert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
            return redirect()->route('user.portfolios.index');
        }
        return view(self::PATH . 'show', compact('portfolio'));
    }

    public function showTrade(Trade $trade)
    {
        try {
            $this->authorize('manage-trade', $trade);
        } catch (\Exception $e) {
            $this->altAlert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
            return redirect()->route('user.portfolios.index');
        }
        return view(self::PATH . 'show-trade', compact('trade'));
    }

    public function export(Portfolio $portfolio)
    {
        try {
            $this->authorize('manage-portfolio', $portfolio);
            return Excel::download(new PortfolioExport($portfolio), 'portfolio-'.substr(md5(mt_rand()), 0, 7).'.xlsx');
        } catch (\Exception $e) {
            $this->altAlert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
            return redirect()->route('user.portfolios.index');
        }
    }
}
