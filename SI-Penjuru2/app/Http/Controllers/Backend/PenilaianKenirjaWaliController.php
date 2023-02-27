<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenilaianKenirjaWaliController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penilaian = DB::table('pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','penilaian.tanggal','penilaian.deadline','penilaian.image')->groupBy('id_penilaian')->get();
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->join('detail_kelas', 'users.id', '=', 'detail_kelas.user_id')->join('kelas', 'detail_kelas.kode_kelas', '=', 'kelas.kode_kelas')->find(Auth::user()->id);
        $no = 1; 
        $tanggal = Carbon::now('Asia/Jakarta');
        $dt = $tanggal->toDateString();
        $future = $tanggal->addWeek();
        $walii = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->where('user_id', Auth::user()->id)->get();
        $dataguru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->join('detail_kelas', 'users.id', '=', 'detail_kelas.user_id')->where('detail_kelas.kode_kelas', $wali->kode_kelas)->get();
        /* dd($future); */
        return view('backend/wali.penilaiankinerjawali', compact('admin','guru', 'wali', 'penilaian','dt','future','walii','dataguru'));
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
}
