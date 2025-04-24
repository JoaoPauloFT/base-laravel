<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class FieldText extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $field;
    public $name;
    public $placeholder;
    public $customAttributes;
    public $formId;
    public $value;
    public $maxlength;
    public $oldValue;

    public function __construct($field, $name, $placeholder = "", $customAttributes = "", $formId = "", $value = "", $maxlength='',$oldValue=false)
    {
        $this->field = $field;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->customAttributes = $customAttributes;
        $this->formId = $formId;
        $this->value = $value;
        $this->maxlength = $maxlength;
        $this->oldValue = $oldValue;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.field-text');
    }
}
