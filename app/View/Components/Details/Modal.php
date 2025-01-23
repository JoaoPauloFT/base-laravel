<?php

namespace App\View\Components\Details;

use Illuminate\View\Component;

class Modal extends Component
{
    public $idItem;
    public $isFooter;
    public $title;
    public $textButtonConfirm;
    public $textButtonCancel;
    public $iconButtonConfirm;
    public $confirmAction;
    public $cancelAction;
    public $buttonAdditional;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $idItem = '', $textButtonConfirm = '', $iconButtonConfirm = '', $confirmAction = '', $cancelAction = '', $textButtonCancel = '', $buttonAdditional = '', $isFooter = false)
    {
        $this->idItem = $idItem;
        $this->isFooter = $isFooter;
        $this->title = $title;
        $this->iconButtonConfirm = $iconButtonConfirm;
        $this->cancelAction = $cancelAction;
        $this->confirmAction = $confirmAction;
        $this->buttonAdditional = $buttonAdditional;

        if ($textButtonCancel == '')
            $textButtonCancel = __('message.cancel');

        $this->textButtonCancel = $textButtonCancel;

        if ($textButtonConfirm == '')
            $textButtonConfirm = __('message.save');

        $this->textButtonConfirm = $textButtonConfirm;
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
