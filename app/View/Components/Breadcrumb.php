<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Diglactic\Breadcrumbs\Breadcrumbs;

class Breadcrumb extends Component
{
    public $trailName;

    public function __construct($trailName)
    {
        $this->trailName = $trailName;
    }

    public function render()
    {
        return view('components.breadcrumb', [
            'breadcrumbs' => Breadcrumbs::has() ? Breadcrumbs::render($this->trailName) : null,
        ]);
    }
}
