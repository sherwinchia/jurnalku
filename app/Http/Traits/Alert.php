<?php

namespace App\Http\Traits;

trait Alert
{
    public function getListeners()
    {
        return ['new'];
    }

    public function alert($data)
    {
        if (isset($data['session'])){
            $data['session'] === true ? session()->flash('alert', $data) : null;
        }
        $this->emitTo('shared.components.alert', "new", $data);
    }
}
