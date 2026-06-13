<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SelectProperty extends Component
{
    public string $name;
    public string $label;
    public mixed $value;
    public array $options;
    public ?string $class;
    public bool $multiple;
    public bool $compact;
     public ?string $placeholder;

    public function __construct(
        string $name,
        string $label = '',
        mixed $value = null,
        array $options = [],
        ?string $class = null,
        bool $multiple = false,
        bool $compact = false,
        ?string $placeholder = null
    ) {
        $this->name = $name;
        $this->label = $label ?: ucfirst($name);
        $this->value = $value;
        $this->options = $options;
        $this->class = $class;
        $this->multiple = $multiple;
        $this->compact = $compact;
        $this->placeholder = $placeholder;
    }

    public function render(): View|Closure|string
    {
        return view('components.select-property');
    }
}