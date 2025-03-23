<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class addTrainingForm extends Component
{

    public $date;
    public $location;
    public $shotMade;
    public $attempt;
    public $duration;
    /**
     * Create a new component instance.
     */
    public function __construct(
        // $date = 'yyyy-mm-dd',
        // $location = 'Default Location',
        // $shotMade = 0,
        // $attempt = 0,
        // $duration = 0,
    ) {
        // $this->date = $date;
        // $this->location = $location;
        // $this->shotMade = $shotMade;
        // $this->attempt = $attempt;
        // $this->duration = $duration;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.add-training-form');
    }
}
