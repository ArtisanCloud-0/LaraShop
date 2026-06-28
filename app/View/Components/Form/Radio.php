<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Radio extends Component
{
    public string $for;
    public string $title;
    /**
     * Create a new component instance.
     */
    public function __construct(string $for, string $title)
    {
        $this->for = $for;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.radio');
    }
}
