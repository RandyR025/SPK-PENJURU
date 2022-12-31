<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class HasilPenilaianExcelExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->collection;
    }
}
