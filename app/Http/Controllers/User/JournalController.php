<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Traits\Alert;
use App\Models\Trade;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;

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
        // $this->authorize('view-trade', $trade);
        if (! Gate::allows('view-trade', $trade)) {
            $this->altAlert([
                "type"=>"error",
                "message"=>"This action is unauthorized!"
            ]);

            return redirect()->route('user.journals.index');
        }
        return view(self::PATH . 'show', compact('trade'));
    }
}
