<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AdminSideMenu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $mainMenu='';
     public $subMenu='';
    public function __construct($mainMenu,$subMenu)
    {
        $this->mainMenu = $mainMenu;
        $this->subMenu = $subMenu;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        
        return view('components.admin-side-menu');
    }
}
