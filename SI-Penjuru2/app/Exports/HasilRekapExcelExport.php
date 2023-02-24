<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Hasilpilihan;
use Illuminate\Support\Facades\DB;
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

class HasilRekapExcelExport implements FromView, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     //
    // }
    public function __construct($firstmonth,$lastmonth,$firstyear,$lastyear)
    {
        $this->firstmonth = $firstmonth;
        $this->lastmonth = $lastmonth;
        $this->firstyear = $firstyear;
        $this->lastyear = $lastyear;
    }
    public function view(): View
    {
        $penilaian = DB::table('penilaian')->whereMonth('tanggal','>=',$this->firstmonth)->whereMonth('tanggal','<=',$this->lastmonth)->whereYear('tanggal','>=',$this->firstyear)->whereYear('tanggal','<=',$this->lastyear)->get();
        $no = 1;
        foreach ($penilaian as $keyval => $val) {
            $coba1[$keyval] = DB::table('users')->join('hasil', 'users.id', '=', 'hasil.user_id')->where('hasil.id_penilaian', '=', $val->id_penilaian)->get();
            foreach ($coba1[$keyval] as $key => $value) {
                $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan', '=', 'pilihan.kode_pilihan')->where('hasilpilihan.user_id', '=', $value->user_id)->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->where('pengisian.id_penilaian', '=', $val->id_penilaian)->get();
            }
            $pengisian[$keyval] = DB::table('pengisian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where('id_penilaian','=',$val->id_penilaian)->get();
        }
        return view('backend/admin.hasilrekap_excel',[
            'coba1'=>$coba1,
            'coba' => $coba,
            'pengisian'=>$pengisian,
            'penilaian'=>$penilaian,
            'no'=>$no,

        ]);
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
