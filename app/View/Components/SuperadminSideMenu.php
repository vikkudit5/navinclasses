<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SuperadminSideMenu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $mainSuperAdminMenu='';
    public $superadminSubMenu='';
   public function __construct($mainSuperAdminMenu,$superadminSubMenu)
   {
       $this->mainSuperAdminMenu = $mainSuperAdminMenu;
       $this->superadminSubMenu = $superadminSubMenu;
   }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.superadmin-side-menu');
    }
}
