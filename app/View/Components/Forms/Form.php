<?php

namespace App\View\Components\forms;

use Closure;
use Illuminate\View\Component;


class Form extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $idItem;
    public $route;
    public $isUpdate;

    public function __construct($idItem, $route, $isUpdate = false)
    {
        $this->idItem = $idItem;
        $this->route = $route;
        $this->isUpdate = $isUpdate;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.form');
    }
}
