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
        $this->emitTo('shared.components.alert', "new", $data);
    }
}
