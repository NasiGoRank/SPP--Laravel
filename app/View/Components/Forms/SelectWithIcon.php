<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectWithIcon extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name, // Jika tidak ada default value (=''), maka wajib diisi di view
        public string $label,
        public string $icon,
        public string $id = '',
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.forms.select-with-icon');
    }
}
