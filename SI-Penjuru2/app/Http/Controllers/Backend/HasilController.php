<?php

namespace App\Http\Controllers\Backend;

use App\Exports\HasilPenilaianRangkingExcelExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class HasilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $waktu = Carbon::now('Asia/Jakarta');
        $nowBulan = $waktu->format('m');
        $nowTahun = $waktu->format('Y');
        // dd($nowTahun);
        $firstmonth = $request->get('firstmonth');
        $lastmonth = $request->get('lastmonth');
        $firstyear = $request->get('firstyear');
        $lastyear = $request->get('lastyear');
        // dd($firstmonth);
        if (isset($firstmonth) && isset($lastmonth) && isset($firstyear) && isset($lastyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal.tanggal','>=',$firstmonth)->whereMonth('tanggal.tanggal','<=',$lastmonth)->whereYear('tanggal.tanggal','>=',$firstyear)->whereYear('tanggal.tanggal','<=',$lastyear)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($firstyear) && isset($lastyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereYear('tanggal.tanggal','>=',$firstyear)->whereYear('tanggal.tanggal','<=',$lastyear)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($firstmonth) && isset($lastmonth)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal.tanggal','>=',$firstmonth)->whereMonth('tanggal.tanggal','<=',$lastmonth)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($firstmonth) && isset($firstyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal.tanggal','=',$firstmonth)->whereYear('tanggal.tanggal','=',$firstyear)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($firstmonth) && isset($lastyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal.tanggal','=',$firstmonth)->whereYear('tanggal.tanggal','=',$lastyear)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($lastmonth) && isset($firstyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal.tanggal','=',$lastmonth)->whereYear('tanggal.tanggal','=',$firstyear)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($lastmonth) && isset($lastyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal.tanggal','<=',$lastmonth)->whereYear('tanggal.tanggal','=',$lastyear)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($firstmonth)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal.tanggal','=',$firstmonth)->whereYear('tanggal.tanggal','=',$nowTahun)->groupBy('jumlah_total.tanggal_id')->get();
            // dd($penilaian);
        }elseif (isset($lastmonth)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal.tanggal','=',$lastmonth)->whereYear('tanggal.tanggal','=',$nowTahun)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($firstyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereYear('tanggal.tanggal','=',$firstyear)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($lastyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereYear('tanggal.tanggal','=',$lastyear)->groupBy('jumlah_total.tanggal_id')->get();
        }else{
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal.tanggal','=',$nowBulan)->whereYear('tanggal.tanggal','=',$nowTahun)->groupBy('jumlah_total.tanggal_id')->get();
            // dd($penilaian);
        }
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);
        // dd($penilaian);
        return view('backend/admin.hasil_data_rangking', compact('admin','guru', 'wali','penilaian'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$tgl)
    {
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);
        $hasil = DB::table('jumlah_total')->join('users', 'jumlah_total.user_id_guru','=','users.id')->join('guru', 'users.id', '=', 'guru.user_id')->where('id_penilaian','=',$id)->where('tanggal_id','=',$tgl)->orderBy('totals','desc')->get();
        $penilaian = DB::table('penilaian')->where('id_penilaian', $id)->get();
        // dd($hasil);
        $no = 1;
        return view('backend/admin.hasil_rangking', compact('admin','guru', 'wali','hasil','no','penilaian'));
    }
    public function showwali($id,$tgl)
    {
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);
        $hasil = DB::table('jumlah_wali_total')->join('users', 'jumlah_wali_total.user_id_guru','=','users.id')->join('guru', 'users.id', '=', 'guru.user_id')->where('id_penilaian','=',$id)->where('tanggal_id','=',$tgl)->orderBy('totals','desc')->get();
        $penilaian = DB::table('penilaian')->where('id_penilaian', $id)->get();
        // dd($hasil);
        $cek = "walikelas";
        $no = 1;
        return view('backend/admin.hasil_rangking', compact('admin','guru', 'wali','hasil','no','penilaian','cek'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cetak_pdf($id,$tgl){
        $penilaian = DB::table('penilaian')->where('id_penilaian', $id)->get();
        $no = 1;
        $jumlah_total = DB::table('jumlah_total')->join('users', 'jumlah_total.user_id_guru','=','users.id')->join('penilaian','jumlah_total.id_penilaian','=','penilaian.id_penilaian')->where('penilaian.id_penilaian','=',$id)->where('tanggal_id','=',$tgl)->orderBy('totals','desc')->get();
        $pdf = PDF::loadview('backend/admin.hasilpenilaianrangking_pdf',['jumlah_total'=>$jumlah_total,'data'=>'Laporan Hasil Rangking','penilaian'=>$penilaian, 'no'=>$no]);
        return $pdf->stream('laporan-hasil-rangking');
    }
    public function cetak_pdf_wali($id,$tgl){
        $penilaian = DB::table('penilaian')->where('id_penilaian', $id)->get();
        $no = 1;
        $jumlah_total = DB::table('jumlah_wali_total')->join('users', 'jumlah_wali_total.user_id_guru','=','users.id')->join('penilaian','jumlah_wali_total.id_penilaian','=','penilaian.id_penilaian')->where('penilaian.id_penilaian','=',$id)->where('tanggal_id','=',$tgl)->orderBy('totals','desc')->get();
        $pdf = PDF::loadview('backend/admin.hasilpenilaianrangking_pdf',['jumlah_total'=>$jumlah_total,'data'=>'Laporan Hasil Rangking','penilaian'=>$penilaian, 'no'=>$no]);
        return $pdf->stream('laporan-hasil-rangking');
    }

    public function eksport_excel($id,$tgl){
        $cek = "guru";
        return Excel::download(new HasilPenilaianRangkingExcelExport($id,$cek,$tgl),'penilaian.xlsx');
    }
    public function eksport_excel_wali($id,$tgl){
        $cek = "wali";
        return Excel::download(new HasilPenilaianRangkingExcelExport($id,$cek,$tgl),'penilaian.xlsx');
    }
}
