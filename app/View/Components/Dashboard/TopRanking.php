<?php

namespace App\View\Components\Dashboard;

use Illuminate\View\Component;

class TopRanking extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $title;
    public $legend;
    public $id;
    public $infos;
    public $switch;
    public $default;

    public function __construct($title, $legend, $id, $infos, $switch = true, $default = 'quantity')
    {
        $this->title = $title;
        $this->legend = $legend;
        $this->id = $id;
        $this->infos = $infos;
        $this->switch = $switch;
        $this->default = $default;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.top-ranking');
    }
}
