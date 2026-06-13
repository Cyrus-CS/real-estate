<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputProperty extends Component
{

    public string $name;
    public string $type;
    public string $label;
    public mixed $value;
    public ?string $class;
    public bool $multiple;
    
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name,
        string $type = 'text',
        string $label = '',
        mixed $value = '',
        ?string $class = null,
        bool $multiple = false
    )
    {
        $this->name = $name;
        $this->type = $type;
        $this->label = $label ?: ucfirst($name);
        $this->value = $value;
        $this->class = $class;
        $this->multiple = $multiple;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input-property');
    }
}