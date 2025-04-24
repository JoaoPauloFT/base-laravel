<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tabs extends Component
{
 /**
     * Create a new component instance.
     */

     public $tabs;
     public $idItem;
     public $fullHeight;
     public $fullWidth;
     public $active;
     public $noBorder; //Removendo a borda e cor das tabs quando usado com o componente de table

     public function __construct($tabs=[],$idItem="",$fullHeight=false, $fullWidth=false, $active="0", $noBorder = false)
     {
        $this->tabs = $tabs;
        $this->idItem = $idItem;
        $this->fullHeight = $fullHeight;
        $this->fullWidth = $fullWidth;
        $this->active = $active;
        $this->noBorder = $noBorder;
     }

     /**
      * Get the view / contents that represent the component.
      */

    public function render(): View|Closure|string
    {
        return view('components.common.tabs');
    }
}
