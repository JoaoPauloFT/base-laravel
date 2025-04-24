<?php

namespace App\View\Components\forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Radio extends Component
{
    /**
     * Create a new component instance.
     */
    public $formId;
    public $field;
    public $name;
    public $options;
    public $class;
    public $value;
    public $onLoad;

    public function __construct($formId = "", $field, $name, $options, $class = "" , $value = "", $onLoad = true)
    {
        $this->formId = $formId;
        $this->field = $field;
        $this->name = $name;
        $this->options = $options;
        $this->class = $class;
        $this->value = $value != "" ? $value : array_key_first($options);
        $this->onLoad = $onLoad;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.radio');
    }
}
