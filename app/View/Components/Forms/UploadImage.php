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

    public $width;
    public $height;
    public $idModal;
    public $idItem;
    public $maxSize;
    public $completeFunction;
    public $field;
    public $path;

    public function __construct($idModal, $width = 0, $height = 0, $maxSize = 0, $field = "file", $idItem = '', $completeFunction = '', $path = 'images/temp')
    {
        $this->width = $width;
        $this->height = $height;
        $this->idModal = $idModal;
        $this->field = $field;
        $this->idItem = $idItem;
        $this->maxSize = $maxSize;
        $this->path = $path;
        if ($completeFunction)
            $this->completeFunction = $completeFunction;
        else
            $this->completeFunction = 'completeUpload'.$idItem;
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
