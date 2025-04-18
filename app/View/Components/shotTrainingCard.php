<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class shotTrainingCard extends Component
{
    /**
     * Create a new component instance.
     */

     public $overallShot;
    //  public $shotTraining;

    public function __construct($overallShot)
    {
        $this->overallShot = $overallShot;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.shot-training-card');
    }
}
