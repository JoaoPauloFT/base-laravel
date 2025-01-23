<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class ChangePassword extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $title;
    public $description;
    public $route;
    public $idItem;
    public $restrictUserPassword;
    public $generatePassword;

    public function __construct($title, $description, $route, $idItem = '', $restrictUserPassword = false, $generatePassword = false)
    {
        $this->title = $title;
        $this->description = $description;
        $this->route = $route;
        $this->idItem = $idItem;
        $this->restrictUserPassword = $restrictUserPassword;
        $this->generatePassword = $generatePassword;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.change-password');
    }
}
