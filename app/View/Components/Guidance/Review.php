<?php

namespace App\View\Components\Guidance;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Review extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?array $reviewer = null,
        public int $iteration = 1
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.guidance.review');
    }
}
