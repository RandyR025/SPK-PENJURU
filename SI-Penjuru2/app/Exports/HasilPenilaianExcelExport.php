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
    public function __construct($id,$tgl)
    {
        $this->id = $id;
        $this->tgl = $tgl;
    }
    public function view(): View
    {
        $penilaian = DB::table('penilaian')->where('id_penilaian', $this->id)->get();
        $no = 1;
        /* Kepala Sekolah */
        /* $coba1 = DB::table('users')->join('hasilkepsek','users.id','=','hasilkepsek.user_id_guru')->where('hasilkepsek.id_penilaian','=',$this->id)->where('hasilkepsek.tanggal_id','=',$this->tgl)->get();
        foreach ($coba1 as $key => $value) {
            $coba[$key] = DB::table('hasilpilihankepsek')->join('pilihan', 'hasilpilihankepsek.kode_pilihan','=','pilihan.kode_pilihan')->where('hasilpilihankepsek.user_id_guru','=',$value->user_id_guru)->join('pengisian','pilihan.kode_pengisian','=','pengisian.kode_pengisian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where('pengisian.id_penilaian', '=', $this->id)->where('hasilpilihankepsek.tanggal_id', '=', $this->tgl)->orderBy('subkriteria.kode_subkriteria','asc')->get();
        } */
        /* Kepala Sekolah */

        /* Wali Murid */
        $wali_kelas = DB::table('guru')->join('detail_kelas','guru.user_id','=','detail_kelas.user_id')->join('kelas','detail_kelas.kode_kelas','=','kelas.kode_kelas')->join('users','guru.user_id','=','users.id')->get();
        foreach ($wali_kelas as $key => $value) {
            // dd($wali_kelas);
            $coba1[$key] = DB::table('users')->join('hasilwali','users.id','=','hasilwali.user_id_wali')->join('detail_kelas','users.id','=','detail_kelas.user_id')->where('detail_kelas.kode_kelas','=',$value->kode_kelas)->where('hasilwali.user_id_guru','=',$value->user_id)->where('hasilwali.id_penilaian','=',$this->id)->where('hasilwali.tanggal_id','=',$this->tgl)->get();
            foreach ($coba1[$key] as $keyy => $valuee) {
                $coba[$keyy] = DB::table('hasilpilihanwali')->join('pilihan', 'hasilpilihanwali.kode_pilihan','=','pilihan.kode_pilihan')->where('hasilpilihanwali.user_id_wali','=',$valuee->user_id_wali)->where('hasilpilihanwali.user_id_guru','=',$value->user_id)->join('pengisian','pilihan.kode_pengisian','=','pengisian.kode_pengisian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where('pengisian.id_penilaian', '=', $this->id)->where('hasilpilihanwali.tanggal_id', '=', $this->tgl)->orderBy('subkriteria.kode_subkriteria','asc')->get();
            }
        }
        /* Wali Murid */
        $pengisian = DB::table('subkriteria')->join('pengisian','subkriteria.kode_subkriteria','=','pengisian.kode_subkriteria')->where('id_penilaian','=',$this->id)->orderBy('subkriteria.kode_subkriteria','asc')->get();
        // $pengisiantelahdifilter = [];
        // foreach ($pengisian as $key => $value) {
        //     $tes = json_decode($value->level);
        //     if (property_exists( $tes, 'guru') ) {
        //         array_push($pengisiantelahdifilter, $value);
        //     }
        // }
        // dd($pengisian);
        return view('backend/admin.hasil_excel',[
            'coba1'=>$coba1,
            'coba' => $coba,
            'pengisian'=>$pengisian,
            'penilaian'=>$penilaian,
            'no'=>$no,
            'wali_kelas'=>$wali_kelas,

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
