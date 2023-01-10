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

class HasilPenilaianExcelExport implements FromView, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    // public function collection()
    // {
    //     $coba= array();
    //     $coba1 = DB::table('users')->join('hasil','users.id','=','hasil.user_id')->where('hasil.id_penilaian','=',$this->id)->get();
    //     foreach ($coba1 as $key => $value) {
    //         // $coba[$key] = (string) DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan','=','pilihan.kode_pilihan')->where('hasilpilihan.user_id','=',$value->user_id);
    //         $coba[$key] = Hasilpilihan::where('user_id','=',$value->user_id)->join('pilihan', 'hasilpilihan.kode_pilihan','=','pilihan.kode_pilihan')->where('hasilpilihan.user_id','=',$value->user_id)->get();
    //     }
    //     // foreach ($coba as $valuecoba) {
    //     //     $value->field
    //     // }
    //     // dd($coba);
    //     return collect($coba);
    // }
    // public function map($coba):array
    // {
    //     return [
    //         //data yang dari kolom tabel database yang akan diambil
    //         $coba[0]->kode_pilihan,
    //         $coba[0]->kode_pengisian,
    //     ];
    // }
    public function __construct($id)
    {
        $this->id = $id;
    }
    public function view(): View
    {
        $penilaian = DB::table('penilaian')->where('id_penilaian', $this->id)->get();
        $no = 1;
        $coba1 = DB::table('users')->join('hasil','users.id','=','hasil.user_id')->where('hasil.id_penilaian','=',$this->id)->get();
        foreach ($coba1 as $key => $value) {
            $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan','=','pilihan.kode_pilihan')->where('hasilpilihan.user_id','=',$value->user_id)->join('pengisian','pilihan.kode_pengisian','=','pengisian.kode_pengisian')->get();
        }
        $pengisian = DB::table('pengisian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where('id_penilaian','=',$this->id)->get();
        return view('backend/admin.hasil_excel',[
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
                    'outline' => [
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
