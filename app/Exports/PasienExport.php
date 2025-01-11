<?php

namespace App\Exports;

use App\Models\Pasie;
use Maatwebsite\Excel\Concerns\FromCollection;

class PasienExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Pasie::all();
    }
}
