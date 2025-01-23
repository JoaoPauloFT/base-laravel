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
    public $titleImage;
    public $width;
    public $height;
    public $idModal;
    public $textButtonCancel;
    public $textButtonConfirm;
    public $iconButtonConfirm;
    public $idItem;
    public $multiColumn;
    public $confirmAction;
    public $cancelAction;
    public $customForm;

    public function __construct($title, $description, $route, $textButtonConfirm, $iconButtonConfirm = '', $titleImage = '', $width = 0, $height = 0, $idModal = 'modalForm', $idItem = '', $multiColumn = false, $confirmAction = '', $cancelAction = '', $textButtonCancel = '', $customForm = '')
    {
        $this->title = $title;
        $this->description = $description;
        $this->route = $route;
        $this->textButtonConfirm = $textButtonConfirm;
        $this->iconButtonConfirm = $iconButtonConfirm;
        $this->titleImage = $titleImage;
        $this->width = $width;
        $this->height = $height;
        $this->idModal = $idModal;
        $this->idItem = $idItem;
        $this->multiColumn = $multiColumn;
        $this->customForm = $customForm;

        if ($textButtonCancel == '')
            $textButtonCancel = __('message.cancel');

        $this->textButtonCancel = $textButtonCancel;

        if ($confirmAction == '')
            $confirmAction = 'submit'.$idItem.'()';

        $this->confirmAction = $confirmAction;

        $this->cancelAction = $cancelAction;
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
