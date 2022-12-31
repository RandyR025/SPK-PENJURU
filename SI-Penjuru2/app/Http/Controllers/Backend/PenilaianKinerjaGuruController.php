<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Hasil;
use App\Models\Hasilpilihan;
use App\Models\Pengisian;
use App\Models\Penilaian;
use App\Models\Pilihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;

class PenilaianKinerjaGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penilaian = DB::table('pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian')->groupBy('id_penilaian')->get();
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);
        $no = 1; 
        // dd($penilaian);
        return view('backend/guru.penilaiankinerjaguru', compact('admin','guru', 'wali', 'penilaian'));
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
        // $pengisian = DB::table('pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->where('penilaian.id_penilaian',$id)->get();
        // foreach ($pengisian as $key => $value) {
        //     $pilihan[$key] = DB::table('pilihan')->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->groupByRaw('pilihan.kode_pengisian')->having('pilihan.kode_pengisian','=',$value->kode_pengisian)->get();
        // }
        // $pilihan = DB::table('pilihan')->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->having('pilihan.kode_pengisian','=','C1')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->where('penilaian.id_penilaian',$id)->get();
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);

        // $pengisian = collect(DB::table('pilihan')->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->where('penilaian.id_penilaian',$id)->join('subkriteria', 'pengisian.kode_subkriteria', '=', 'subkriteria.kode_subkriteria')->join('kriteria', 'subkriteria.kode_kriteria', '=', 'kriteria.kode_kriteria')->get()->groupBy('kode_pengisian'));
        $jumlah = Pengisian::with('penilaian')->where('id_penilaian','=',$id)->get()->count();
        $coba1 = Pengisian::with('penilaian')->where('id_penilaian','=',$id)->paginate(1);
        foreach ($coba1 as $key => $value) {
            $coba[$key] = Pilihan::with('pengisian')->where('kode_pengisian','=',$value->kode_pengisian)->get();
        }
        // dd($coba);
        $hasilpilihan = DB::table('hasilpilihan')->where('user_id','=',Auth::user()->id)->get();
        // dd($hasilpilihan);
        return view('backend/guru.detailkinerjaguru', compact('admin','guru', 'wali','coba','coba1','hasilpilihan','jumlah'));
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


    public function hasilpilihan(Request $request){
        $query = Hasilpilihan::where([
            ['user_id','=',Auth::user()->id],
            ['kode_pengisian','=',$request->pengisian_id],
        ])->count();

        if ($query == 0) {
            $hasilpilihan = new Hasilpilihan;
            // return $request;
            // $pilihan = "answer".$request->input('question');
            $hasilpilihan->kode_pilihan = $request->option_id;
            $hasilpilihan->kode_pengisian = $request->pengisian_id;
            $hasilpilihan->user_id = Auth::user()->id;
            $hasilpilihan->save();   
        }else {
            Hasilpilihan::where([
            ['user_id','=',Auth::user()->id],
            ['kode_pengisian','=',$request->pengisian_id],
        ])->update(['kode_pilihan'=> $request->option_id]);
        }
    }

    public function totalnilai($id){
        // $nilaikriteria = DB::table('kriteria')->join('pv_kriteria', 'kriteria.kode_kriteria','=','pv_kriteria.id_kriteria')->get();
        // foreach ($nilaikriteria as $keykriteria => $valuekriteria) {
        //     $nilaisubkriteria[$keykriteria] = DB::table('subkriteria')->join('pv_subkriteria','subkriteria.kode_subkriteria','=','pv_subkriteria.id_subkriteria')->where('subkriteria.kode_kriteria','=',$valuekriteria->kode_kriteria)->get();
        //     foreach ($nilaisubkriteria as $keysubkriteria => $valuesubkriteria) {
        //         foreach ($valuesubkriteria as $keynilaisub => $valuenilaisub) {
        //             $nilaipengisian[$keynilaisub] = DB::table('pilihan')->join('hasilpilihan','pilihan.kode_pilihan','=','hasilpilihan.kode_pilihan')->where('hasilpilihan.user_id','=',Auth::user()->id)->join('pengisian','pilihan.kode_pengisian','=','pengisian.kode_pengisian')->where('pengisian.kode_subkriteria',$valuenilaisub->kode_subkriteria)->get();
        //         }
        //     }
        //     dd($nilaipengisian);
        // }

            $coba = DB::table('pengisian')->where('id_penilaian','=',$id)->get();
            $nilai = 0;
            foreach ($coba as $key => $value) {
                $coba1[$key] = DB::table('hasilpilihan')
                ->where('hasilpilihan.kode_pengisian','=',$value->kode_pengisian)
                ->where('user_id','=',Auth::user()->id)
                ->join('pilihan','hasilpilihan.kode_pilihan','=','pilihan.kode_pilihan')
                ->join('pengisian','hasilpilihan.kode_pengisian','=','pengisian.kode_pengisian')
                ->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')
                ->join('kriteria','subkriteria.kode_kriteria','=','kriteria.kode_kriteria')
                ->join('pv_subkriteria','subkriteria.kode_subkriteria','=','pv_subkriteria.id_subkriteria')
                ->join('pv_kriteria','kriteria.kode_kriteria','=','pv_kriteria.id_kriteria')->first();
                $nilai = $nilai + $coba1[$key]->points * $coba1[$key]->nilai_kriteria * $coba1[$key]->nilai_subkriteria ;   
            }
            

            $query = Hasil::where([
                ['user_id','=',Auth::user()->id],
                ['id_penilaian','=',$id],
            ])->count();
            if ($query == 0) {     
                $total = new Hasil;
                $total->totals = round($nilai,5);
                $total->user_id = Auth::user()->id;
                $total->id_penilaian = $id;
                $total->save();
            }else {
                Hasil::where([
                    ['user_id','=',Auth::user()->id],
                    ['id_penilaian','=',$id],
                ])->update(['totals'=> round($nilai,5)]);
            }
            
            // dd($coba1);
            return redirect()->route('penilaiankinerjaguru');
    }
}
