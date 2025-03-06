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
    public $ordering;
    public $moment;
    public $customColumns;
    public $serverSide;
    public $columnsSide;
    public $routes;
    public $hasExport;

    public function __construct($dropdownFilter = [], $dropdownMultipleFilter = [], $click = "", $hideColumn = [], $ordering = "[[0, 'asc']]", $moment = "DD/MM/YYYY", $widthColumns = [], $notOrderColumns = [], $serverSide = false, $columnsSide = [], $routes = "", $hasExport = true)
    {
        //
        $this->dropdownFilter = $dropdownFilter;
        $this->dropdownMultipleFilter = $dropdownMultipleFilter;
        $this->click = $click;
        $this->ordering = $ordering;
        $this->moment = $moment;
        $columns = [];
        foreach ($hideColumn as $column) {
            $columns[$column] = "visible: false, ";
        }
        foreach ($widthColumns as $key => $width) {
            $columns[$key] = ($columns[$key] ?? "") . 'width: "'. $width .'px", ';
        }
        foreach ($notOrderColumns as $key => $width) {
            $columns[$key] = ($columns[$key] ?? "") . "orderable: false, ";
        }
        $this->customColumns = $columns;
        $this->serverSide = $serverSide;
        $this->columnsSide = $columnsSide;
        $this->routes = $routes;
        $this->hasExport = $hasExport;
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
