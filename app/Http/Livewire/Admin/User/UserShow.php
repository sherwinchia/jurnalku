<?php

namespace App\Http\Livewire\Admin\User;

use Livewire\Component;

class UserShow extends Component
{
    public $user;

    public function mount($model)
    {
        $this->user = $model;
    }
    public function render()
    {
        return view('livewire.admin.user.user-show', [
            'transactions' => $this->user->transactions()->with('package')->paginate(10),
        ]);
    }
}
