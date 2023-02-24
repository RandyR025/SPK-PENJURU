<?php

namespace App\Http\Controllers\Backend;

use App\Exports\HasilRekapExcelExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;

class RekapLaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);
        return view('backend/admin.rekaplaporan', compact('admin', 'guru', 'wali'));
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
        //
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

    public function cetak(Request $request)
    {
        $firstmonth = $request->get('firstmonth');
        $lastmonth = $request->get('lastmonth');
        $firstyear = $request->get('firstyear');
        $lastyear = $request->get('lastyear');
        $opsi = $request->get('opsi');
        if ($opsi == "pdf") {
            if (isset($firstmonth) && isset($lastmonth) && isset($firstyear) && isset($lastyear)) {
                $penilaian = DB::table('penilaian')->whereMonth('tanggal','>=',$firstmonth)->whereMonth('tanggal','<=',$lastmonth)->whereYear('tanggal','>=',$firstyear)->whereYear('tanggal','<=',$lastyear)->get();
                $no = 1;
                foreach ($penilaian as $keyval => $val) {
                    $coba1[$keyval] = DB::table('users')->join('hasil', 'users.id', '=', 'hasil.user_id')->where('hasil.id_penilaian', '=', $val->id_penilaian)->get();
                    foreach ($coba1[$keyval] as $key => $value) {
                        $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan', '=', 'pilihan.kode_pilihan')->where('hasilpilihan.user_id', '=', $value->user_id)->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->where('pengisian.id_penilaian', '=', $val->id_penilaian)->get();
                    }
                    $pengisian[$keyval] = DB::table('pengisian')->where('id_penilaian', '=', $val->id_penilaian)->get();
                }
                // dd($coba);
                $pdf = PDF::loadview('backend/admin.rekaplaporan_pdf', ['coba' => $coba, 'coba1' => $coba1, 'pengisian' => $pengisian, 'penilaian' => $penilaian, 'no' => $no, 'data' => 'Rekap Laporan Hasil Penilaian']);
                return $pdf->stream('rekap-laporan-hasil-penilaian');
            } elseif (isset($firstyear) && isset($lastyear)) {
                
            } elseif (isset($firstmonth) && isset($lastmonth)) {
                
            } elseif (isset($firstmonth)) {
                
            } elseif (isset($lastmonth)) {
                
            } elseif (isset($firstyear)) {
                
            } elseif (isset($lastyear)) {
                
            } else {
                
            }
        } elseif ($opsi == "excel") {
            if (isset($firstmonth) && isset($lastmonth) && isset($firstyear) && isset($lastyear)) {
                return Excel::download(new HasilRekapExcelExport($firstmonth,$lastmonth,$firstyear,$lastyear),'RekapLaporan.xlsx');
            } elseif (isset($firstyear) && isset($lastyear)) {
                
            } elseif (isset($firstmonth) && isset($lastmonth)) {
                
            } elseif (isset($firstmonth)) {
                
            } elseif (isset($lastmonth)) {
                
            } elseif (isset($firstyear)) {
                
            } elseif (isset($lastyear)) {
                
            } else {
                
            }
        }else {
            return redirect()->route('rekaplaporan');
        }
    }
}
