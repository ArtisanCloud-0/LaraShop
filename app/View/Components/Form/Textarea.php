<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Textarea extends Component
{
    public string $for = '';
    public string $label = '';
    public string $placeholder = '';
    /**
     * Create a new component instance.
     */
    public function __construct(string $for, string $label, string $placeholder)
    {
        $this->for = $for;
        $this->label = $label;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.textarea');
    }
}
