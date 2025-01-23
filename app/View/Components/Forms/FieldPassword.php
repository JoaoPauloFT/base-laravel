<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class FieldPassword extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $generatePassword;

    public function __construct($generatePassword = false)
    {
        $this->generatePassword = $generatePassword;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.field-password');
    }
}
