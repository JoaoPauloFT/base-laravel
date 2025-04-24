<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $title;
    public $description;
    public $route;
    public $idModal;
    public $textButtonCancel;
    public $textButtonConfirm;
    public $iconButtonConfirm;
    public $idItem;
    public $classAdd;
    public $confirmAction;
    public $cancelAction;
    public $customForm;
    public $buttonAdditional;

    public function __construct($title, $description, $route, $textButtonConfirm, $iconButtonConfirm = '', $idModal = 'modalForm', $idItem = '', $classAdd = "", $confirmAction = '', $cancelAction = '', $textButtonCancel = '', $customForm = '', $buttonAdditional='')
    {
        $this->title = $title;
        $this->description = $description;
        $this->route = $route;
        $this->textButtonConfirm = $textButtonConfirm;
        $this->iconButtonConfirm = $iconButtonConfirm;
        $this->idModal = $idModal;
        $this->idItem = $idItem;
        $this->classAdd = $classAdd;
        $this->customForm = $customForm;

        if ($textButtonCancel == '')
            $textButtonCancel = __('message.cancel');

        $this->textButtonCancel = $textButtonCancel;

        if ($confirmAction == '')
            $confirmAction = 'submit'.$idItem.'()';

        $this->confirmAction = $confirmAction;

        $this->cancelAction = $cancelAction;
        $this->buttonAdditional = $buttonAdditional;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.modal');
    }
}
