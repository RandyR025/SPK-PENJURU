<?php

namespace App\Exports;

use App\Models\Hasilpilihan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class HasilPenilaianRangkingExcelExport implements FromView, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     //
    // }
    public function __construct($id,$cek)
    {
        $this->id = $id;
        $this->cek = $cek;
    }
    public function view(): View
    {
        if ($this->cek == "guru") {
            $penilaian = DB::table('penilaian')->where('id_penilaian', $this->id)->get();
            $no = 1;
            $jumlah_total = DB::table('jumlah_total')->join('users', 'jumlah_total.user_id_guru','=','users.id')->join('penilaian','jumlah_total.id_penilaian','=','penilaian.id_penilaian')->where('penilaian.id_penilaian','=',$this->id)->get();
            return view('backend/admin.hasilrangking_excel',[
                'jumlah_total'=>$jumlah_total,
                'penilaian'=>$penilaian,
                'no'=>$no,
    
            ]);
        }elseif ($this->cek == "wali") {
            $penilaian = DB::table('penilaian')->where('id_penilaian', $this->id)->get();
            $no = 1;
            $jumlah_total = DB::table('jumlah_wali_total')->join('users', 'jumlah_wali_total.user_id_guru','=','users.id')->join('penilaian','jumlah_wali_total.id_penilaian','=','penilaian.id_penilaian')->where('penilaian.id_penilaian','=',$this->id)->get();
            return view('backend/admin.hasilrangking_excel',[
                'jumlah_total'=>$jumlah_total,
                'penilaian'=>$penilaian,
                'no'=>$no,
            ]);
        }
    }
    public function registerEvents(): array
{
    return [
        AfterSheet::class    => function(AfterSheet $event) {
            $styleArray = [
                'borders' => [
                    'border' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                        'color' => ['argb' => 'FFFF0000'],
                    ]
                ]
            ];
            $event->sheet->getDelegate()->getStyle('B2:G8')->applyFromArray($styleArray);
        },
    ];
}
}
