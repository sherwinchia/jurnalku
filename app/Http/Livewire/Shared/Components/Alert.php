<?php

namespace App\Http\Livewire\Shared\Components;

use Livewire\Component;

class Alert extends Component
{
    public $alerts = array();

    public function getListeners()
    {
        return ['new'];
    }

    public function mount()
    {
        if (session()->has('alert')) {
            array_push($this->alerts, session()->get('alert'));
        } 
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
