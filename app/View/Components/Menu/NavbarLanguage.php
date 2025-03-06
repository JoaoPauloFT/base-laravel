<?php

namespace App\View\Components\Menu;

use Illuminate\View\Component;

class NavbarLanguage extends Component
{
    public $id;
    public $icon;
    public $url;
    public $languages;
    public $enableDropdownMode;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id, $icon, $url, $languages = [], $enableDropdownMode = false) {
        $this->id = $id;
        $this->icon = $icon;
        $this->url = $url;
        $this->languages = $languages;
        $this->enableDropdownMode = boolval($enableDropdownMode);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.menu.navbar-language');
    }
}
