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
    public $colMd;
    public $field;
    public $name;
    public $formId;
    public $placeholder;
    public $generatePassword;
    public $conditionPassword;

    public function __construct($colMd = "col-md-6", $field = "password", $name = "", $formId = "", $placeholder = "************", $generatePassword = false, $conditionPassword = true)
    {
        $this->colMd =$colMd;
        $this->field = $field;
        $this->name = $name != "" ? $name : __('message.password');
        $this->formId = $formId;
        $this->placeholder = $placeholder;
        $this->generatePassword = $generatePassword;
        $this->conditionPassword = $conditionPassword;
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
