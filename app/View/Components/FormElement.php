<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormElement extends Component
{
    public $name = '';
    public $label = '';
    public $type = '';
    public $items = [];
    public $value = '';
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type = 'text', $name, $label, $items = [], $value='')
    {
        $this->name = $name;
        $this->label = $label;
        $this->type = $type;
        $this->items = $items;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.form-element');
    }
}
