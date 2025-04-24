<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TableActions extends Component
{
    public $id;
    public $hasDetail;
    public $hasEdit;
    public $hasDelete;
    public $item;
    /**
     * Create a new component instance.
     */
    public function __construct(int $id, string $item, bool $hasDetail = true, bool $hasEdit = true, bool $hasDelete = true)
    {
        $this->id = $id;
        $this->item = $item;
        $this->hasDetail = $hasDetail;
        $this->hasEdit = $hasEdit;
        $this->hasDelete = $hasDelete;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.forms.table-actions');
    }
}
