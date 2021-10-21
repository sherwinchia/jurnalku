<?php

namespace App\Http\Livewire\Shared\Components;

use Livewire\Component;

class Alert extends Component
{

    protected $listeners = ['new'];

    public $alerts = array();

    public function mount()
    {

    }

    public function new($data)
    {
        array_push($this->alerts, $data);
    }

    public function remove($key)
    {
        unset($this->alerts[$key]);
    }

    public function render()
    {
        return view('livewire.shared.components.alert');
    }
}
