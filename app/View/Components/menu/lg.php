<?php

namespace App\View\Components\menu;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class lg extends Component
{
    public array $links;
    /**
     * Create a new component instance.
     */
    public function __construct(array $links)
    {
        $this->links = $links;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.menu.lg');
    }
}
