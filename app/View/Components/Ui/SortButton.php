<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class SortButton extends Component
{
    public $sortField;
    public $targetField;
    public $sortAsc;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($targetField, $sortField, $sortAsc)
    {
        $this->sortField = $sortField;
        $this->targetField = $targetField;
        $this->sortAsc = $sortAsc;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.sort-button');
    }
}
