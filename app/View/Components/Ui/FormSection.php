<?php

namespace App\View\Components\Ui;

use Illuminate\View\Component;

class FormSection extends Component
{
    public $field, $required;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($field, $required)
    {
        $this->field = $field;
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ui.form-section');
    }
}
