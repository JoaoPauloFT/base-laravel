<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Checkbox extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $field;
    public $name;
    public $customAttributes;
    public $formId;
    public $checked;

    public function __construct($field, $name, $customAttributes = "", $formId = "", $value = "")
    {
        $this->field = $field;
        $this->name = $name;
        $this->customAttributes = $customAttributes;
        $this->formId = $formId;

        if (old('form') == 'formSubmit'.$formId)
            $this->checked = old($field) == "1";
        else
            $this->checked = $value == "1";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.checkbox');
    }
}
