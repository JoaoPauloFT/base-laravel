<?php

namespace App\View\Components\Config;

use Illuminate\View\Component;

class valueCommission extends Component
{
    public $commission;
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($commission, $value)
    {
        $this->commission = $commission;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.config.value-commission');
    }
}
