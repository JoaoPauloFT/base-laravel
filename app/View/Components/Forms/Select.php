<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Select extends Component
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
    public $options;
    public $formId;
    public $isTab;
    public $customAttributes;
    public $value;
    public $idModal;

    public function __construct($field, $name, $placeholder, $options, $type = "text", $mask = "", $formId = "", $isTab = false, $customAttributes = "", $value = "", $idModal = "modalForm")
    {
        $this->field = $field;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->options = $options;
        $this->type = $type;
        $this->mask = $mask;
        $this->formId = $formId;
        $this->isTab = $isTab;
        $this->customAttributes = $customAttributes;
        $this->value = $value;
        if ($idModal == "modalForm")
            $idModal .= $formId;
        $this->idModal = $idModal;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.select');
    }
}
