<?php

namespace App\View\Components\Details;

use Illuminate\View\Component;

class Tabs extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $tabs;
    public $defaultUrl;
    public $idParent;

    public function __construct($tabs, $defaultUrl = '', $idParent = '')
    {
        $this->tabs = $tabs;
        $this->defaultUrl = $defaultUrl;
        $this->idParent = $idParent;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.details.tabs');
    }
}
