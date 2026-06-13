<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CheckboxProperty extends Component
{
    public ?string $name;
    public ?string $label;
    public ?string $value;
    public ?string $class;
    public bool $multiple;
    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $name = null,
        ?string $label = null,
        ?string $value = null,
        ?string $class = null,
        bool $multiple = true
    )
    {
        $this->name = $name;
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
        return view('components.checkbox-property');
    }
}