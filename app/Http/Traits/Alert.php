<?php

namespace App\Http\Traits;

trait Alert
{
    public function alert($data)
    {
        $data['type'] = strtolower($data['type']);

        if (!isset($data['session'])) {
            $data['session'] = false;
        }

        if (!isset($data['title'])) {
            $data['title'] = ucfirst($data['type']);
        }

        if (!isset($data['color'])) {
            $data['color'] = $this->getColor($data['type']);
        }

        if ($data['session'] === true) {
            session()->flash('alert', $data);
        }

        return $this->emitTo('shared.components.alert', 'new', $data);
    }

    public function getColor($type)
    {
        if ($type == 'success') {
            return config('live-alert.success');
        }
        if ($type == 'error') {
            return config('live-alert.error');
        }
        if ($type == 'warning') {
            return config('live-alert.warning');
        }
        if ($type == 'info') {
            return config('live-alert.info');
        }
    }
}
