<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class UploadImage extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $title;
    public $width;
    public $height;
    public $idModal;
    public $idItem;

    public function __construct($title, $width, $height, $idModal, $idItem = '')
    {
        $this->title = $title;
        $this->width = $width;
        $this->height = $height;
        $this->idModal = $idModal;
        $this->idItem = $idItem;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.forms.upload-image');
    }
}
