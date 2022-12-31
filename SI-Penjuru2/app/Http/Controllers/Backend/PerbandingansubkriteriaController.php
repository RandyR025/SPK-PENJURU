<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PerbandingansubkriteriaController extends Controller
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
        return view('backend/perhitungan.perbandingansubkriteria', compact('admin','guru', 'wali'));
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
        $subkriteria = DB::table('subkriteria')->join('kriteria', 'subkriteria.kode_kriteria', '=', 'kriteria.kode_kriteria')->where('kriteria.kode_kriteria',$id)->get();
        $kriteria = DB::table('kriteria')->where('kode_kriteria', $id)->get();
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);
        $no = 1;
        return view('backend/perhitungan.showperbandingansubkriteria', compact('admin','guru', 'wali', 'subkriteria', 'no', 'kriteria','id'));
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


    public function proses(Request $request)
    {
        $id = $request->id;
        $jenis = $request->jenis;

        if ($jenis == 'kriteria') {
            $n = getJumlahSubkriteria($id);
        } else {
            // $n = getJumlahKriteria(); 

        }
        $matrik = array();
        $urut = 0;
        for ($x = 0; $x <= ($n - 2); $x++) {
            for ($y = ($x+1); $y <= ($n - 1); $y++) {
                $urut++;
                $pilih = "pilih" . $urut;
                $bobot = "bobot" . $urut;
                if ($request->input($pilih) == 1) {
                    $matrik[$x][$y] = $request->$bobot;
                    $matrik[$y][$x] = 1 / $request->$bobot;
                } else {
                    $matrik[$x][$y] = 1 / $request->$bobot;
                    $matrik[$y][$x] = $request->$bobot;
                }

                if ($jenis == 'kriteria') {
                    inputDataPerbandinganSubkriteria($x, $y, $matrik[$x][$y],$id);
                } else {
                    // inputDataPerbandinganAlternatif($x,$y,($jenis-1),$matrik[$x][$y]);
                }
            }
        }

        for ($i = 0; $i <= ($n - 1); $i++) {
            $matrik[$i][$i] = 1;
        }

        $jmlmpb = array();
        $jmlmnk = array();
        for ($i = 0; $i <= ($n - 1); $i++) {
            $jmlmpb[$i] = 0;
            $jmlmnk[$i] = 0;
        }

        for ($x=0; $x <= ($n-1) ; $x++) {
            for ($y=0; $y <= ($n-1) ; $y++) {
                $value		= $matrik[$x][$y];
                $jmlmpb[$y] += $value;
            }
        }

        for ($x=0; $x <= ($n-1) ; $x++) {
            for ($y=0; $y <= ($n-1) ; $y++) {
                $matrikb[$x][$y] = $matrik[$x][$y] / $jmlmpb[$y];
                $value	= $matrikb[$x][$y];
                $jmlmnk[$x] += $value;
            }
    
            // nilai priority vektor
            $pv[$x]	 = $jmlmnk[$x] / $n;
    
            // memasukkan nilai priority vektor ke dalam tabel pv_kriteria dan pv_alternatif
            if ($jenis == 'kriteria') {
                $id_kriteria = getSubkriteriaID($x,$id);
                inputSubkriteriaPv($id_kriteria,$pv[$x],$id);
            } else {
                // $id_kriteria	= getKriteriaID($jenis-1);
                // $id_alternatif	= getAlternatifID($x);
                // inputAlternatifPV($id_alternatif,$id_kriteria,$pv[$x]);
            }
        }

        $eigenvektor = getEigenVector($jmlmpb,$jmlmnk,$n);
	    $consIndex   = getConsIndex($jmlmpb,$jmlmnk,$n);
	    $consRatio   = getConsRatio($jmlmpb,$jmlmnk,$n);

        bantuan($matrik);
        
        return view('backend/perhitungan.outputperbandingansub', compact('matrik','jmlmpb','matrikb','jmlmnk','pv','eigenvektor','consIndex','consRatio','id'));
    }
}
