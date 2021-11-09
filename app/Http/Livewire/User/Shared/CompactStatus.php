<?php

namespace App\Http\Livewire\User\Shared;

use Livewire\Component;

class CompactStatus extends Component
{
    public function render()
    {
        return view('livewire.user.shared.compact-status', [
            'portfolios' => current_user()->portfolios->load('trades')
        ]);
    }
}
