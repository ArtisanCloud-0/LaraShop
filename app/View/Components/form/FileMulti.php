<?php

namespace App\View\Components\form;

use Illuminate\View\Component;
use Illuminate\View\View;

class FileMulti extends Component
{

    public string $for; // The name of the input field
    public string $label; // The label for the input field
    public array $images = []; // The existing images to display in the component
    public array $newImages = []; // The new images to display in the component

    public function __construct(
        string $for,
        string $label,
        array $images,
        array $newImages,
    ) {
        $this->for = $for;
        $this->label = $label;
        $this->images = $images;
        $this->newImages = $newImages;
    } // Initialize the component with the required properties

    public function render(): View
    {
        return view('components.form.file-multi');
    }
}
