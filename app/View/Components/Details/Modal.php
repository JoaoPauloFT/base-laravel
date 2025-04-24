<?php

namespace App\View\Components\Details;

use Illuminate\View\Component;

class Modal extends Component
{
    public $idItem;
    public $hasFooter;
    public $hasConfirm;
    public $title;
    public $description;
    public $textButtonConfirm;
    public $textButtonCancel;
    public $iconButtonConfirm;
    public $confirmAction;
    public $cancelAction;
    public $buttonAdditional;
    public $classAdd;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $idItem = '', $textButtonConfirm = '', $iconButtonConfirm = '', $confirmAction = '', $cancelAction = '', $textButtonCancel = '', $buttonAdditional = '', $hasFooter = false, $hasConfirm = true, $description="", $classAdd="")
    {
        $this->idItem = $idItem;
        $this->hasFooter = $hasFooter;
        $this->title = $title;
        $this->iconButtonConfirm = $iconButtonConfirm;
        $this->cancelAction = $cancelAction;
        $this->confirmAction = $confirmAction;
        $this->buttonAdditional = $buttonAdditional;
        $this->hasConfirm = $hasConfirm;
        $this->description = $description;

        if ($textButtonCancel == '')
            $textButtonCancel = __('message.cancel');

        $this->textButtonCancel = $textButtonCancel;

        if ($textButtonConfirm == '')
            $textButtonConfirm = __('message.save');

        $this->textButtonConfirm = $textButtonConfirm;
        $this->classAdd = $classAdd;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.details.modal');
    }
}
