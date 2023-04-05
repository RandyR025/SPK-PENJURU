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

class HasilRekapRangkingExcelExport implements FromView, ShouldAutoSize, WithEvents
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
            $penilaian = DB::table('tanggal')->join('penilaian','tanggal.id_penilaian','=','penilaian.id_penilaian')->whereMonth('tanggal','>=',$this->firstmonth)->whereMonth('tanggal','<=',$this->lastmonth)->whereYear('tanggal','>=',$this->firstyear)->whereYear('tanggal','<=',$this->lastyear)->get();
            $no = 1;
            if ($this->firstmonth == $this->lastmonth && $this->firstyear == $this->lastyear) {
                foreach ($penilaian as $keyval => $val) {
                    $coba1[$keyval] = DB::table('users')->join('jumlah_total', 'users.id', '=', 'jumlah_total.user_id_guru')->where('jumlah_total.tanggal_id', '=', $val->id)->get();
                }
                return view('backend/admin.hasilrekaprangking_excel',[
                    'coba1'=>$coba1,
                    'penilaian'=>$penilaian,
                    'no'=>$no,
                ]);
            }else {
                $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->join('jumlah_total','users.id','=','jumlah_total.user_id_guru')->join('tanggal','jumlah_total.tanggal_id','=','tanggal.id')->select('users.name',DB::raw('SUM(jumlah_total.totals) as jumlah_nilai'))->whereMonth('tanggal','>=',$this->firstmonth)->whereMonth('tanggal','<=',$this->lastmonth)->whereYear('tanggal','>=',$this->firstyear)->whereYear('tanggal','<=',$this->lastyear)->groupBy('users.id')->orderBy('totals','desc')->get();
                foreach ($penilaian as $keyval => $val) {
                    $coba1[$keyval] = DB::table('users')->join('jumlah_total', 'users.id', '=', 'jumlah_total.user_id_guru')->where('jumlah_total.tanggal_id', '=', $val->id)->get();
                }
                return view('backend/admin.hasilrekaprangking_excel',[
                    'coba1'=>$coba1,
                    'guru' => $guru,
                    'penilaian'=>$penilaian,
                    'no'=>$no,
                    'firstmonth'=>$this->firstmonth,
                    'lastmonth'=>$this->lastmonth,
                    'firstyear'=>$this->firstyear,
                    'lastyear'=>$this->lastyear,
        
                ]);
                
            }
            
        } elseif (isset($this->firstyear) && isset($this->lastyear)) {
            $penilaian = DB::table('tanggal')->join('penilaian','tanggal.id_penilaian','=','penilaian.id_penilaian')->whereYear('tanggal','>=',$this->firstyear)->whereYear('tanggal','<=',$this->lastyear)->get();
            $no = 1;
            if ($this->firstyear == $this->lastyear) {
                foreach ($penilaian as $keyval => $val) {
                    $coba1[$keyval] = DB::table('users')->join('jumlah_total', 'users.id', '=', 'jumlah_total.user_id_guru')->where('jumlah_total.tanggal_id', '=', $val->id)->get();
                }
                return view('backend/admin.hasilrekaprangking_excel',[
                    'coba1'=>$coba1,
                    'penilaian'=>$penilaian,
                    'no'=>$no,
        
                ]);
            }else {
                $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->join('jumlah_total','users.id','=','jumlah_total.user_id_guru')->join('tanggal','jumlah_total.tanggal_id','=','tanggal.id')->select('users.name',DB::raw('SUM(jumlah_total.totals) as jumlah_nilai'))->whereYear('tanggal','>=',$this->firstyear)->whereYear('tanggal','<=',$this->lastyear)->groupBy('users.id')->orderBy('totals','desc')->get();
                foreach ($penilaian as $keyval => $val) {
                    $coba1[$keyval] = DB::table('users')->join('jumlah_total', 'users.id', '=', 'jumlah_total.user_id_guru')->where('jumlah_total.tanggal_id', '=', $val->id)->get();
                }
                return view('backend/admin.hasilrekaprangking_excel',[
                    'coba1'=>$coba1,
                    'guru' => $guru,
                    'penilaian'=>$penilaian,
                    'no'=>$no,
                    'firstmonth'=>$this->firstmonth,
                    'lastmonth'=>$this->lastmonth,
                    'firstyear'=>$this->firstyear,
                    'lastyear'=>$this->lastyear,
        
                ]);
                
            }
        } elseif (isset($this->firstmonth) && isset($this->lastmonth)) {
            $penilaian = DB::table('tanggal')->join('penilaian','tanggal.id_penilaian','=','penilaian.id_penilaian')->whereMonth('tanggal','>=',$this->firstmonth)->whereMonth('tanggal','<=',$this->lastmonth)->whereYear('tanggal','=',$this->now)->whereYear('tanggal','=',$this->now)->get();
            $no = 1;
            if ($this->firstmonth == $this->lastmonth) {
                foreach ($penilaian as $keyval => $val) {
                    $coba1[$keyval] = DB::table('users')->join('jumlah_total', 'users.id', '=', 'jumlah_total.user_id_guru')->where('jumlah_total.tanggal_id', '=', $val->id)->get();
                }
                return view('backend/admin.hasilrekaprangking_excel',[
                    'coba1'=>$coba1,
                    'penilaian'=>$penilaian,
                    'no'=>$no,
        
                ]);
            }else {
                $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->join('jumlah_total','users.id','=','jumlah_total.user_id_guru')->join('tanggal','jumlah_total.tanggal_id','=','tanggal.id')->select('users.name',DB::raw('SUM(jumlah_total.totals) as jumlah_nilai'))->whereMonth('tanggal','>=',$this->firstmonth)->whereMonth('tanggal','<=',$this->lastmonth)->whereYear('tanggal','>=',$this->now)->whereYear('tanggal','<=',$this->now)->groupBy('users.id')->orderBy('totals','desc')->get();
                foreach ($penilaian as $keyval => $val) {
                    $coba1[$keyval] = DB::table('users')->join('jumlah_total', 'users.id', '=', 'jumlah_total.user_id_guru')->where('jumlah_total.tanggal_id', '=', $val->id)->get();
                }
                return view('backend/admin.hasilrekap_excel',[
                    'coba1'=>$coba1,
                    'guru' => $guru,
                    'penilaian'=>$penilaian,
                    'no'=>$no,
                    'firstmonth'=>$this->firstmonth,
                    'lastmonth'=>$this->lastmonth,
                    'firstyear'=>$this->firstyear,
                    'lastyear'=>$this->lastyear,
        
                ]);
                
            }
        } elseif (isset($this->firstmonth) && isset($this->firstyear)) {
            $penilaian = DB::table('tanggal')->join('penilaian','tanggal.id_penilaian','=','penilaian.id_penilaian')->whereMonth('tanggal','=',$this->firstmonth)->whereYear('tanggal','=',$this->firstyear)->get();
            $no = 1;
                $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->join('jumlah_total','users.id','=','jumlah_total.user_id_guru')->join('tanggal','jumlah_total.tanggal_id','=','tanggal.id')->select('users.name',DB::raw('SUM(jumlah_total.totals) as jumlah_nilai'))->whereMonth('tanggal','=',$this->firstmonth)->whereYear('tanggal','=',$this->firstyear)->groupBy('users.id')->orderBy('totals','desc')->get();
                foreach ($penilaian as $keyval => $val) {
                    $coba1[$keyval] = DB::table('users')->join('jumlah_total', 'users.id', '=', 'jumlah_total.user_id_guru')->where('jumlah_total.tanggal_id', '=', $val->id)->get();
                }
                return view('backend/admin.hasilrekaprangking_excel',[
                    'coba1'=>$coba1,
                    'penilaian'=>$penilaian,
                    'no'=>$no,
        
                ]);
        } elseif (isset($this->firstmonth) && isset($this->lastyear)) {
            $penilaian = DB::table('tanggal')->join('penilaian','tanggal.id_penilaian','=','penilaian.id_penilaian')->whereMonth('tanggal','=',$this->firstmonth)->whereYear('tanggal','=',$this->lastyear)->get();
            $no = 1;
                $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->join('jumlah_total','users.id','=','jumlah_total.user_id_guru')->join('tanggal','jumlah_total.tanggal_id','=','tanggal.id')->select('users.name',DB::raw('SUM(jumlah_total.totals) as jumlah_nilai'))->whereMonth('tanggal','=',$this->firstmonth)->whereYear('tanggal','=',$this->lastyear)->groupBy('users.id')->orderBy('totals','desc')->get();
                foreach ($penilaian as $keyval => $val) {
                    $coba1[$keyval] = DB::table('users')->join('jumlah_total', 'users.id', '=', 'jumlah_total.user_id_guru')->where('jumlah_total.tanggal_id', '=', $val->id)->get();
                }
                return view('backend/admin.hasilrekaprangking_excel',[
                    'coba1'=>$coba1,
                    'penilaian'=>$penilaian,
                    'no'=>$no,
        
                ]);
        } elseif (isset($this->lastmonth) && isset($this->firstyear)) {
            $penilaian = DB::table('tanggal')->join('penilaian','tanggal.id_penilaian','=','penilaian.id_penilaian')->whereMonth('tanggal','=',$this->lastmonth)->whereYear('tanggal','=',$this->firstyear)->get();
            $no = 1;
            $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->join('jumlah_total','users.id','=','jumlah_total.user_id_guru')->join('tanggal','jumlah_total.tanggal_id','=','tanggal.id')->select('users.name',DB::raw('SUM(jumlah_total.totals) as jumlah_nilai'))->whereMonth('tanggal','=',$this->lastmonth)->whereYear('tanggal','=',$this->firstyear)->groupBy('users.id')->orderBy('totals','desc')->get();
                foreach ($penilaian as $keyval => $val) {
                    $coba1[$keyval] = DB::table('users')->join('jumlah_total', 'users.id', '=', 'jumlah_total.user_id_guru')->where('jumlah_total.tanggal_id', '=', $val->id)->get();
                }
                return view('backend/admin.hasilrekaprangking_excel',[
                    'coba1'=>$coba1,
                    'penilaian'=>$penilaian,
                    'no'=>$no,
        
                ]);
        } elseif (isset($this->lastmonth) && isset($this->lastyear)) {
            $penilaian = DB::table('tanggal')->join('penilaian','tanggal.id_penilaian','=','penilaian.id_penilaian')->whereMonth('tanggal','=',$this->lastmonth)->whereYear('tanggal','=',$this->lastyear)->get();
            $no = 1;
            $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->join('jumlah_total','users.id','=','jumlah_total.user_id_guru')->join('tanggal','jumlah_total.tanggal_id','=','tanggal.id')->select('users.name',DB::raw('SUM(jumlah_total.totals) as jumlah_nilai'))->whereMonth('tanggal','=',$this->lastmonth)->whereYear('tanggal','=',$this->lastyear)->groupBy('users.id')->orderBy('totals','desc')->get();
                foreach ($penilaian as $keyval => $val) {
                    $coba1[$keyval] = DB::table('users')->join('jumlah_total', 'users.id', '=', 'jumlah_total.user_id_guru')->where('jumlah_total.tanggal_id', '=', $val->id)->get();
                }
                return view('backend/admin.hasilrekaprangking_excel',[
                    'coba1'=>$coba1,
                    'penilaian'=>$penilaian,
                    'no'=>$no,
        
                ]);
        } elseif (isset($this->firstmonth)) {
            $penilaian = DB::table('tanggal')->join('penilaian','tanggal.id_penilaian','=','penilaian.id_penilaian')->whereMonth('tanggal','=',$this->firstmonth)->whereYear('tanggal','=',$this->now)->get();
            $no = 1;
            $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->join('jumlah_total','users.id','=','jumlah_total.user_id_guru')->join('tanggal','jumlah_total.tanggal_id','=','tanggal.id')->select('users.name',DB::raw('SUM(jumlah_total.totals) as jumlah_nilai'))->whereMonth('tanggal','=',$this->firstmonth)->whereYear('tanggal','=',$this->now)->groupBy('users.id')->orderBy('totals','desc')->get();
                foreach ($penilaian as $keyval => $val) {
                    $coba1[$keyval] = DB::table('users')->join('jumlah_total', 'users.id', '=', 'jumlah_total.user_id_guru')->where('jumlah_total.tanggal_id', '=', $val->id)->get();
                }
                return view('backend/admin.hasilrekaprangking_excel',[
                    'coba1'=>$coba1,
                    'penilaian'=>$penilaian,
                    'no'=>$no,
        
                ]);
        } elseif (isset($this->lastmonth)) {
            $penilaian = DB::table('tanggal')->join('penilaian','tanggal.id_penilaian','=','penilaian.id_penilaian')->whereMonth('tanggal','=',$this->lastmonth)->whereYear('tanggal','=',$this->now)->get();
            $no = 1;
            $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->join('jumlah_total','users.id','=','jumlah_total.user_id_guru')->join('tanggal','jumlah_total.tanggal_id','=','tanggal.id')->select('users.name',DB::raw('SUM(jumlah_total.totals) as jumlah_nilai'))->whereMonth('tanggal','=',$this->lastmonth)->whereYear('tanggal','=',$this->now)->groupBy('users.id')->orderBy('totals','desc')->get();
                foreach ($penilaian as $keyval => $val) {
                    $coba1[$keyval] = DB::table('users')->join('jumlah_total', 'users.id', '=', 'jumlah_total.user_id_guru')->where('jumlah_total.tanggal_id', '=', $val->id)->get();
                }
                // dd($guru);
                return view('backend/admin.hasilrekaprangking_excel',[
                    'coba1'=>$coba1,
                    'penilaian'=>$penilaian,
                    'no'=>$no,
        
                ]);
        } elseif (isset($this->firstyear)) {
            $penilaian = DB::table('tanggal')->join('penilaian','tanggal.id_penilaian','=','penilaian.id_penilaian')->whereYear('tanggal','=',$this->firstyear)->get();
            $no = 1;
            $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->join('jumlah_total','users.id','=','jumlah_total.user_id_guru')->join('tanggal','jumlah_total.tanggal_id','=','tanggal.id')->select('users.name',DB::raw('SUM(jumlah_total.totals) as jumlah_nilai'))->whereYear('tanggal','=',$this->firstyear)->groupBy('users.id')->orderBy('totals','desc')->get();
                foreach ($penilaian as $keyval => $val) {
                    $coba1[$keyval] = DB::table('users')->join('jumlah_total', 'users.id', '=', 'jumlah_total.user_id_guru')->where('jumlah_total.tanggal_id', '=', $val->id)->get();
                }
                return view('backend/admin.hasilrekaprangking_excel',[
                    'coba1'=>$coba1,
                    'guru' => $guru,
                    'penilaian'=>$penilaian,
                    'no'=>$no,
                    'firstyear'=>$this->firstyear,
        
                ]);
        } elseif (isset($this->lastyear)) {
            $penilaian = DB::table('tanggal')->join('penilaian','tanggal.id_penilaian','=','penilaian.id_penilaian')->whereYear('tanggal','=',$this->lastyear)->get();
            $no = 1;
            $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->join('jumlah_total','users.id','=','jumlah_total.user_id_guru')->join('tanggal','jumlah_total.tanggal_id','=','tanggal.id')->select('users.name',DB::raw('SUM(jumlah_total.totals) as jumlah_nilai'))->whereYear('tanggal','=',$this->lastyear)->groupBy('users.id')->orderBy('totals','desc')->get();
                foreach ($penilaian as $keyval => $val) {
                    $coba1[$keyval] = DB::table('users')->join('jumlah_total', 'users.id', '=', 'jumlah_total.user_id_guru')->where('jumlah_total.tanggal_id', '=', $val->id)->get();
                }
                return view('backend/admin.hasilrekaprangking_excel',[
                    'coba1'=>$coba1,
                    'guru' => $guru,
                    'penilaian'=>$penilaian,
                    'no'=>$no,
                    'lastyear'=>$this->lastyear,
        
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
