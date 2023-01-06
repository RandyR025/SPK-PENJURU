<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class HasilPenilaianExcelExport extends  DefaultValueBinder implements FromCollection, WithCustomCsvSettings, WithHeadings, ShouldAutoSize, WithCustomValueBinder
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($id)
    {
        $this->id = $id;
    }
    public function bindValue(Cell $cell, $value)
    {
        if (is_string($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }

    public function headings(): array
    {
        return ["Name", "Email"];
    }
    public function collection()
    {
        $coba= array();
        $coba1 = DB::table('users')->join('hasil','users.id','=','hasil.user_id')->where('hasil.id_penilaian','=',$this->id)->get();
        foreach ($coba1 as $key => $value) {
            $coba[$key] = (string) DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan','=','pilihan.kode_pilihan')->where('hasilpilihan.user_id','=',$value->user_id)->join('pengisian','pilihan.kode_pengisian','=','pengisian.kode_pengisian')->get();
        }
        // foreach ($coba as $valuecoba) {
        //     $value->field
        // }
        dd($coba);
        return $coba;
    }
}
