<?php

namespace App\View\Components\form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileMulti extends Component
{

    public string $for = '';
    public string $label = '';
    public array $images = [];
    public array $new_images = [];
    public string $filesTypes = '';

    /**
     * Create a new component instance.
     */
    public function __construct(string $for, string $label, array $images,  array $new_images, string $filesTypes)
    {
        $this->for = $for;
        $this->label = $label;
        $this->images = $images;
        $this->new_images = $new_images;
        $this->filesTypes = $filesTypes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.file-multi');
    }
}
