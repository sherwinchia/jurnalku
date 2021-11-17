<?php

namespace App\Http\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;

class UserShow extends Component
{
    use WithPagination;
    public $user;

    public function paginationView()
    {
        return 'admin.partials.pagination';
    }

    public function render()
    {
        return view('livewire.admin.user.user-show', [
            'transactions' => $this->user->transactions()->orderBy('created_at', 'desc')->paginate(10),
        ]);
    }
}
