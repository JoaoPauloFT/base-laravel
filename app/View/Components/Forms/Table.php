<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Table extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $dropdownFilter;
    public $dropdownMultipleFilter;
    public $click;
    public $hideColumn;
    public $ordering;
    public $moment;

    public function __construct($dropdownFilter = [], $dropdownMultipleFilter = [], $click = "", $hideColumn = array(), $ordering = "[[0, 'asc']]", $moment = "DD/MM/YYYY")
    {
        //
        $this->dropdownFilter = $dropdownFilter;
        $this->dropdownMultipleFilter = $dropdownMultipleFilter;
        $this->click = $click;
        $this->hideColumn = $hideColumn;
        $this->ordering = $ordering;
        $this->moment = $moment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.table');
    }
}
