<?php

namespace App\Exports;

use App\Models\SanteMesure;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SanteMesuresExport implements FromView
{
    protected $mesures;

    public function __construct($mesures)
    {
        $this->mesures = $mesures;
    }

    public function view(): View
    {
        return view('exports.sante-mesures-excel', [
            'mesures' => $this->mesures
        ]);
    }
}