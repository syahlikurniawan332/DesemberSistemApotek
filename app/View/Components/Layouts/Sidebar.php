<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use App\Models\Medicine;
use Illuminate\Support\Facades\Cache;

class Sidebar extends Component
{
    public $stokRendah;

    public function __construct()
    {
        $this->stokRendah = Cache::remember(
            'sidebar.low_stock_count',
            now()->addSeconds(30),
            fn () => Medicine::lowStock()->count(),
        );
    }

    public function render()
    {
        return view('components.layouts.sidebar');
    }
}
