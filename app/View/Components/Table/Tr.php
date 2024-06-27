<?php

namespace App\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tr extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public ?string $trClass = null

    ) {
        $this->trClass = join(' ', [
            'even:bg-primary-50 bg-white hover:bg-primary-100 dark:bg-slate-800 dark:even:bg-slate-700 dark:text-white dark:hover:bg-slate-600',
            $trClass
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table.tr');
    }
}
