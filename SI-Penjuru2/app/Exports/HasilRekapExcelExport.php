<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Hasilpilihan;
use Carbon\Carbon;
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
        $waktu = Carbon::now('Asia/Jakarta');
        $this->now = $waktu->format('Y');
        $this->firstmonth = $firstmonth;
        $this->lastmonth = $lastmonth;
        $this->firstyear = $firstyear;
        $this->lastyear = $lastyear;
    }
    public function view(): View
    {
        if (isset($this->firstmonth) && isset($this->lastmonth) && isset($this->firstyear) && isset($this->lastyear)) {
            $penilaian = DB::table('tanggal')->join('penilaian','tanggal.id_penilaian','=','penilaian.id_penilaian')->whereMonth('tanggal.tanggal','>=',$this->firstmonth)->whereMonth('tanggal.tanggal','<=',$this->lastmonth)->whereYear('tanggal.tanggal','>=',$this->firstyear)->whereYear('tanggal.tanggal','<=',$this->lastyear)->get();
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
        }elseif (isset($this->firstyear) && isset($this->lastyear)) {
            $penilaian = DB::table('penilaian')->whereYear('tanggal','>=',$this->firstyear)->whereYear('tanggal','<=',$this->lastyear)->get();
            $no = 1;
            foreach ($penilaian as $keyval => $val) {
                $coba1[$keyval] = DB::table('users')->join('hasil', 'users.id', '=', 'hasil.user_id')->where('hasil.id_penilaian', '=', $val->id_penilaian)->get();
                foreach ($coba1[$keyval] as $key => $value) {
                    $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan', '=', 'pilihan.kode_pilihan')->where('hasilpilihan.user_id', '=', $value->user_id)->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->where('pengisian.id_penilaian', '=', $val->id_penilaian)->get();
                }
                $pengisian[$keyval] = DB::table('pengisian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where('id_penilaian','=',$val->id_penilaian)->where('pengisian.level','=','guru')->get();
            }
            return view('backend/admin.hasilrekap_excel',[
                'coba1'=>$coba1,
                'coba' => $coba,
                'pengisian'=>$pengisian,
                'penilaian'=>$penilaian,
                'no'=>$no,
    
            ]);
        }elseif (isset($this->firstmonth) && isset($this->lastmonth)) {
            $penilaian = DB::table('penilaian')->whereMonth('tanggal','>=',$this->firstmonth)->whereMonth('tanggal','<=',$this->lastmonth)->whereYear('tanggal','=',$this->now)->whereYear('tanggal','=',$this->now)->get();
            $no = 1;
            foreach ($penilaian as $keyval => $val) {
                $coba1[$keyval] = DB::table('users')->join('hasil', 'users.id', '=', 'hasil.user_id')->where('hasil.id_penilaian', '=', $val->id_penilaian)->get();
                foreach ($coba1[$keyval] as $key => $value) {
                    $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan', '=', 'pilihan.kode_pilihan')->where('hasilpilihan.user_id', '=', $value->user_id)->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->where('pengisian.id_penilaian', '=', $val->id_penilaian)->get();
                }
                $pengisian[$keyval] = DB::table('pengisian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where('id_penilaian','=',$val->id_penilaian)->where('pengisian.level','=','guru')->get();
            }
            return view('backend/admin.hasilrekap_excel',[
                'coba1'=>$coba1,
                'coba' => $coba,
                'pengisian'=>$pengisian,
                'penilaian'=>$penilaian,
                'no'=>$no,
    
            ]);
        }elseif (isset($this->firstmonth) && isset($this->firstyear)) {
            $penilaian = DB::table('penilaian')->whereMonth('tanggal','=',$this->firstmonth)->whereYear('tanggal','=',$this->firstyear)->get();
            $no = 1;
            foreach ($penilaian as $keyval => $val) {
                $coba1[$keyval] = DB::table('users')->join('hasil', 'users.id', '=', 'hasil.user_id')->where('hasil.id_penilaian', '=', $val->id_penilaian)->get();
                foreach ($coba1[$keyval] as $key => $value) {
                    $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan', '=', 'pilihan.kode_pilihan')->where('hasilpilihan.user_id', '=', $value->user_id)->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->where('pengisian.id_penilaian', '=', $val->id_penilaian)->get();
                }
                $pengisian[$keyval] = DB::table('pengisian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where('id_penilaian','=',$val->id_penilaian)->where('pengisian.level','=','guru')->get();
            }
            return view('backend/admin.hasilrekap_excel',[
                'coba1'=>$coba1,
                'coba' => $coba,
                'pengisian'=>$pengisian,
                'penilaian'=>$penilaian,
                'no'=>$no,
    
            ]);
        }elseif (isset($this->firstmonth) && isset($this->lastyear)) {
            $penilaian = DB::table('penilaian')->whereMonth('tanggal','=',$this->firstmonth)->whereYear('tanggal','=',$this->lastyear)->get();
            $no = 1;
            foreach ($penilaian as $keyval => $val) {
                $coba1[$keyval] = DB::table('users')->join('hasil', 'users.id', '=', 'hasil.user_id')->where('hasil.id_penilaian', '=', $val->id_penilaian)->get();
                foreach ($coba1[$keyval] as $key => $value) {
                    $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan', '=', 'pilihan.kode_pilihan')->where('hasilpilihan.user_id', '=', $value->user_id)->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->where('pengisian.id_penilaian', '=', $val->id_penilaian)->get();
                }
                $pengisian[$keyval] = DB::table('pengisian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where('id_penilaian','=',$val->id_penilaian)->where('pengisian.level','=','guru')->get();
            }
            return view('backend/admin.hasilrekap_excel',[
                'coba1'=>$coba1,
                'coba' => $coba,
                'pengisian'=>$pengisian,
                'penilaian'=>$penilaian,
                'no'=>$no,
    
            ]);
        }elseif (isset($this->lastmonth) && isset($this->firstyear)) {
            $penilaian = DB::table('penilaian')->whereMonth('tanggal','=',$this->lastmonth)->whereYear('tanggal','=',$this->firstyear)->get();
            $no = 1;
            foreach ($penilaian as $keyval => $val) {
                $coba1[$keyval] = DB::table('users')->join('hasil', 'users.id', '=', 'hasil.user_id')->where('hasil.id_penilaian', '=', $val->id_penilaian)->get();
                foreach ($coba1[$keyval] as $key => $value) {
                    $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan', '=', 'pilihan.kode_pilihan')->where('hasilpilihan.user_id', '=', $value->user_id)->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->where('pengisian.id_penilaian', '=', $val->id_penilaian)->get();
                }
                $pengisian[$keyval] = DB::table('pengisian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where('id_penilaian','=',$val->id_penilaian)->where('pengisian.level','=','guru')->get();
            }
            return view('backend/admin.hasilrekap_excel',[
                'coba1'=>$coba1,
                'coba' => $coba,
                'pengisian'=>$pengisian,
                'penilaian'=>$penilaian,
                'no'=>$no,
    
            ]);
        }elseif (isset($this->lastmonth) && isset($this->lastyear)) {
            $penilaian = DB::table('penilaian')->whereMonth('tanggal','=',$this->lastmonth)->whereYear('tanggal','=',$this->lastyear)->get();
            $no = 1;
            foreach ($penilaian as $keyval => $val) {
                $coba1[$keyval] = DB::table('users')->join('hasil', 'users.id', '=', 'hasil.user_id')->where('hasil.id_penilaian', '=', $val->id_penilaian)->get();
                foreach ($coba1[$keyval] as $key => $value) {
                    $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan', '=', 'pilihan.kode_pilihan')->where('hasilpilihan.user_id', '=', $value->user_id)->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->where('pengisian.id_penilaian', '=', $val->id_penilaian)->get();
                }
                $pengisian[$keyval] = DB::table('pengisian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where('id_penilaian','=',$val->id_penilaian)->where('pengisian.level','=','guru')->get();
            }
            return view('backend/admin.hasilrekap_excel',[
                'coba1'=>$coba1,
                'coba' => $coba,
                'pengisian'=>$pengisian,
                'penilaian'=>$penilaian,
                'no'=>$no,
    
            ]);
        }elseif (isset($this->firstmonth)) {
            $penilaian = DB::table('penilaian')->whereMonth('tanggal','=',$this->firstmonth)->whereYear('tanggal','=',$this->now)->get();
            $no = 1;
            foreach ($penilaian as $keyval => $val) {
                $coba1[$keyval] = DB::table('users')->join('hasil', 'users.id', '=', 'hasil.user_id')->where('hasil.id_penilaian', '=', $val->id_penilaian)->get();
                foreach ($coba1[$keyval] as $key => $value) {
                    $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan', '=', 'pilihan.kode_pilihan')->where('hasilpilihan.user_id', '=', $value->user_id)->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->where('pengisian.id_penilaian', '=', $val->id_penilaian)->get();
                }
                $pengisian[$keyval] = DB::table('pengisian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where('id_penilaian','=',$val->id_penilaian)->where('pengisian.level','=','guru')->get();
            }
            return view('backend/admin.hasilrekap_excel',[
                'coba1'=>$coba1,
                'coba' => $coba,
                'pengisian'=>$pengisian,
                'penilaian'=>$penilaian,
                'no'=>$no,
    
            ]);
        }elseif (isset($this->lastmonth)) {
            $penilaian = DB::table('penilaian')->whereMonth('tanggal','=',$this->lastmonth)->whereYear('tanggal','=',$this->now)->get();
            $no = 1;
            foreach ($penilaian as $keyval => $val) {
                $coba1[$keyval] = DB::table('users')->join('hasil', 'users.id', '=', 'hasil.user_id')->where('hasil.id_penilaian', '=', $val->id_penilaian)->get();
                foreach ($coba1[$keyval] as $key => $value) {
                    $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan', '=', 'pilihan.kode_pilihan')->where('hasilpilihan.user_id', '=', $value->user_id)->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->where('pengisian.id_penilaian', '=', $val->id_penilaian)->get();
                }
                $pengisian[$keyval] = DB::table('pengisian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where('id_penilaian','=',$val->id_penilaian)->where('pengisian.level','=','guru')->get();
            }
            return view('backend/admin.hasilrekap_excel',[
                'coba1'=>$coba1,
                'coba' => $coba,
                'pengisian'=>$pengisian,
                'penilaian'=>$penilaian,
                'no'=>$no,
    
            ]);
        }elseif (isset($this->firstyear)) {
            $penilaian = DB::table('penilaian')->whereYear('tanggal','>=',$this->firstyear)->get();
            $no = 1;
            foreach ($penilaian as $keyval => $val) {
                $coba1[$keyval] = DB::table('users')->join('hasil', 'users.id', '=', 'hasil.user_id')->where('hasil.id_penilaian', '=', $val->id_penilaian)->get();
                foreach ($coba1[$keyval] as $key => $value) {
                    $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan', '=', 'pilihan.kode_pilihan')->where('hasilpilihan.user_id', '=', $value->user_id)->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->where('pengisian.id_penilaian', '=', $val->id_penilaian)->get();
                }
                $pengisian[$keyval] = DB::table('pengisian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where('id_penilaian','=',$val->id_penilaian)->where('pengisian.level','=','guru')->get();
            }
            return view('backend/admin.hasilrekap_excel',[
                'coba1'=>$coba1,
                'coba' => $coba,
                'pengisian'=>$pengisian,
                'penilaian'=>$penilaian,
                'no'=>$no,
    
            ]);
        }elseif (isset($this->lastyear)) {
            $penilaian = DB::table('penilaian')->whereYear('tanggal','<=',$this->lastyear)->get();
            $no = 1;
            foreach ($penilaian as $keyval => $val) {
                $coba1[$keyval] = DB::table('users')->join('hasil', 'users.id', '=', 'hasil.user_id')->where('hasil.id_penilaian', '=', $val->id_penilaian)->get();
                foreach ($coba1[$keyval] as $key => $value) {
                    $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan', '=', 'pilihan.kode_pilihan')->where('hasilpilihan.user_id', '=', $value->user_id)->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->where('pengisian.id_penilaian', '=', $val->id_penilaian)->get();
                }
                $pengisian[$keyval] = DB::table('pengisian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where('id_penilaian','=',$val->id_penilaian)->where('pengisian.level','=','guru')->get();
            }
            return view('backend/admin.hasilrekap_excel',[
                'coba1'=>$coba1,
                'coba' => $coba,
                'pengisian'=>$pengisian,
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
