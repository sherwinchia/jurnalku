<?php

namespace App\View\Components\layout;

use Illuminate\View\Component;

class User extends Component
{
    public $header, $balance;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($header = null)
    {
        $this->header = $header;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout.user');
    }
}
