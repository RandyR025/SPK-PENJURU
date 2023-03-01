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
            $penilaian = DB::table('jumlah_total')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','penilaian.tanggal','penilaian.image')->whereMonth('penilaian.tanggal','>=',$firstmonth)->whereMonth('penilaian.tanggal','<=',$lastmonth)->whereYear('penilaian.tanggal','>=',$firstyear)->whereYear('penilaian.tanggal','<=',$lastyear)->groupBy('id_penilaian')->get();
        }elseif (isset($firstyear) && isset($lastyear)) {
            $penilaian = DB::table('jumlah_total')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','penilaian.tanggal','penilaian.image')->whereYear('penilaian.tanggal','>=',$firstyear)->whereYear('penilaian.tanggal','<=',$lastyear)->groupBy('id_penilaian')->get();
        }elseif (isset($firstmonth) && isset($lastmonth)) {
            $penilaian = DB::table('jumlah_total')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','penilaian.tanggal','penilaian.image')->whereMonth('penilaian.tanggal','>=',$firstmonth)->whereMonth('penilaian.tanggal','<=',$lastmonth)->groupBy('id_penilaian')->get();
        }elseif (isset($firstmonth) && isset($firstyear)) {
            $penilaian = DB::table('jumlah_total')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','penilaian.tanggal','penilaian.image')->whereMonth('penilaian.tanggal','=',$firstmonth)->whereYear('penilaian.tanggal','=',$firstyear)->groupBy('id_penilaian')->get();
        }elseif (isset($firstmonth) && isset($lastyear)) {
            $penilaian = DB::table('jumlah_total')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','penilaian.tanggal','penilaian.image')->whereMonth('penilaian.tanggal','=',$firstmonth)->whereYear('penilaian.tanggal','=',$lastyear)->groupBy('id_penilaian')->get();
        }elseif (isset($lastmonth) && isset($firstyear)) {
            $penilaian = DB::table('jumlah_total')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','penilaian.tanggal','penilaian.image')->whereMonth('penilaian.tanggal','=',$lastmonth)->whereYear('penilaian.tanggal','=',$firstyear)->groupBy('id_penilaian')->get();
        }elseif (isset($lastmonth) && isset($lastyear)) {
            $penilaian = DB::table('jumlah_total')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','penilaian.tanggal','penilaian.image')->whereMonth('penilaian.tanggal','<=',$lastmonth)->whereYear('penilaian.tanggal','=',$lastyear)->groupBy('id_penilaian')->get();
        }elseif (isset($firstmonth)) {
            $penilaian = DB::table('jumlah_total')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','penilaian.tanggal','penilaian.image')->whereMonth('penilaian.tanggal','=',$firstmonth)->whereYear('penilaian.tanggal','=',$nowTahun)->groupBy('id_penilaian')->get();
            // dd($penilaian);
        }elseif (isset($lastmonth)) {
            $penilaian = DB::table('jumlah_total')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','penilaian.tanggal','penilaian.image')->whereMonth('penilaian.tanggal','=',$lastmonth)->whereYear('penilaian.tanggal','=',$nowTahun)->groupBy('id_penilaian')->get();
        }elseif (isset($firstyear)) {
            $penilaian = DB::table('jumlah_total')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','penilaian.tanggal','penilaian.image')->whereYear('penilaian.tanggal','=',$firstyear)->groupBy('id_penilaian')->get();
        }elseif (isset($lastyear)) {
            $penilaian = DB::table('jumlah_total')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','penilaian.tanggal','penilaian.image')->whereYear('penilaian.tanggal','=',$lastyear)->groupBy('id_penilaian')->get();
        }else{
            $penilaian = DB::table('jumlah_total')->join('penilaian', 'jumlah_total.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','penilaian.tanggal','penilaian.image')->whereMonth('penilaian.tanggal','=',$nowBulan)->whereYear('penilaian.tanggal','=',$nowTahun)->groupBy('id_penilaian')->get();
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
    public function show($id)
    {
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);
        $hasil = DB::table('jumlah_total')->join('users', 'jumlah_total.user_id_guru','=','users.id')->join('guru', 'users.id', '=', 'guru.user_id')->where('id_penilaian','=',$id)->orderBy('totals','desc')->get();
        $penilaian = DB::table('penilaian')->where('id_penilaian', $id)->get();
        // dd($hasil);
        $no = 1;
        return view('backend/admin.hasil_rangking', compact('admin','guru', 'wali','hasil','no','penilaian'));
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

    public function cetak_pdf($id){
        $penilaian = DB::table('penilaian')->where('id_penilaian', $id)->get();
        $no = 1;
        $jumlah_total = DB::table('jumlah_total')->join('users', 'jumlah_total.user_id_guru','=','users.id')->join('penilaian','jumlah_total.id_penilaian','=','penilaian.id_penilaian')->where('penilaian.id_penilaian','=',$id)->get();
        $pdf = PDF::loadview('backend/admin.hasilpenilaianrangking_pdf',['jumlah_total'=>$jumlah_total,'data'=>'Laporan Hasil Rangking','penilaian'=>$penilaian, 'no'=>$no]);
        return $pdf->stream('laporan-hasil-rangking');
    }

    public function eksport_excel($id){
        return Excel::download(new HasilPenilaianRangkingExcelExport($id),'penilaian.xlsx');
    }
}
