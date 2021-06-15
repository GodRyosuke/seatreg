<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListTable extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $keys = [];
    public $records = [];
    public $record_keys = [];

    public function __construct($keys, $record_keys, $records)
    {
        $this->keys = $keys;
        $this->record_keys = $record_keys;
        $this->records = $records;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.list-table');
    }
}
