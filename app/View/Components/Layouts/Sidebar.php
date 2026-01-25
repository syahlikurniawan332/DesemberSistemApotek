<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use App\Models\Medicine;

class Sidebar extends Component
{
    public $stokRendah;

    public function __construct()
    {
        $this->stokRendah = Medicine::withSum('batches', 'stok')
            ->get()
            ->where('batches_sum_stok', '<=', 10)
            ->count();
    }

    public function render()
    {
        return view('components.layouts.sidebar');
    }
}
