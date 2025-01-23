<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Field extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $field;
    public $name;
    public $type;
    public $placeholder;
    public $mask;
    public $customAttributes;
    public $formId;
    public $value;

    public function __construct($field, $name, $placeholder = "", $type = "text", $mask = "", $customAttributes = "", $formId = "", $value = "")
    {
        $this->field = $field;
        $this->name = $name;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->mask = $mask;
        $this->customAttributes = $customAttributes;
        $this->formId = $formId;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.field');
    }
}
