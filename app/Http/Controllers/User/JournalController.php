<?php

namespace App\Http\Controllers\User;

use App\Exports\PortfolioExport;
use App\Http\Controllers\Controller;
use App\Http\Traits\Alert;
use App\Models\Trade;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class JournalController extends Controller
{
    use AuthorizesRequests, Alert;

    const PATH = "user.journal.";

    public function index()
    {
        return view(self::PATH . 'index');
    }

    public function show(Trade $trade)
    {
        try {
            $this->authorize('manage-trade', $trade);
        } catch (\Exception $e) {
            $this->altAlert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
            return redirect()->route('user.journals.index');
        }
        return view(self::PATH . 'show', compact('trade'));
    }

    public function export($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
            return Excel::download(new PortfolioExport($id), 'portfolio-'.substr(md5(mt_rand()), 0, 7).'.xlsx');
        } catch (\Exception $e) {
            $this->altAlert([
                "type" => "error",
                "message" => $e->getMessage()
            ]);
            return redirect()->route('user.journals.index');
        }
    }
}
