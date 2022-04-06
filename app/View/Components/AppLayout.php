<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\View\ComponentSlot;

class AppLayout extends Component
{
    public function __construct(
        public ?string $title = null,
        public ?string $fullTitle = null,
        public bool $noindex = false,
        public bool $ogp_tags = true,
        public ?ComponentSlot $sidebar = null,
    ) {}

    public function render(): View
    {
        return view('layouts.app');
    }
}
