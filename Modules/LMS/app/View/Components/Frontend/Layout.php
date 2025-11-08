<?php

namespace Modules\LMS\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Layout extends Component
{
    protected $data = [];
    protected $class = '';

    /**
     * Create a new component instance.
     */
    public function __construct($data = [], $class = '')
    {
        $this->data = $data;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $attibutes = [
            'data' => $this->data,
            'body_class' => $this->class,
        ];
        return view('theme::layouts.master', $attibutes);
    }
}
