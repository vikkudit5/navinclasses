<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FrontNavBar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    
    // public $frontMenu='';
   public function __construct()
   {
    //    $this->frontMenu = $frontMenu;
    //    $this->subMenu = $subMenu;
   }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.front-nav-bar');
    }
}
