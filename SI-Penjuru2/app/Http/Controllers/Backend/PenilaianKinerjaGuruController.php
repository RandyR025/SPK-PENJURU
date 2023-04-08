<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Hasil;
use App\Models\Hasilpilihan;
use App\Models\Pengisian;
use App\Models\Penilaian;
use App\Models\Pilihan;
use App\Models\JumlahTotal;
use App\Models\JumlahWaliTotal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PenilaianKinerjaGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penilaian = DB::table('pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->join('tanggal', 'penilaian.id_penilaian', '=', 'tanggal.id_penilaian')->get();
        $penilaianfilter = [];
            foreach ($penilaian as $key => $data) {
                    $tes = json_decode($data->level);
                    if (property_exists( $tes, 'guru') ) {
                        array_push($penilaianfilter, $data);
                    }
                }
            $oke = collect($penilaianfilter)->groupBy('id');
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);
        $no = 1; 
        $tanggal = Carbon::now('Asia/Jakarta');
        $dt = $tanggal->toDateString();
        $future = $tanggal->addWeek();
        /* dd($future); */
        return view('backend/guru.penilaiankinerjaguru', compact('admin','guru', 'wali', 'penilaian','dt','future','oke'));
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
        // $pengisian = DB::table('pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->where('penilaian.id_penilaian',$id)->get();
        // foreach ($pengisian as $key => $value) {
        //     $pilihan[$key] = DB::table('pilihan')->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->groupByRaw('pilihan.kode_pengisian')->having('pilihan.kode_pengisian','=',$value->kode_pengisian)->get();
        // }
        // $pilihan = DB::table('pilihan')->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->having('pilihan.kode_pengisian','=','C1')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->where('penilaian.id_penilaian',$id)->get();
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);

        // $pengisian = collect(DB::table('pilihan')->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->where('penilaian.id_penilaian',$id)->join('subkriteria', 'pengisian.kode_subkriteria', '=', 'subkriteria.kode_subkriteria')->join('kriteria', 'subkriteria.kode_kriteria', '=', 'kriteria.kode_kriteria')->get()->groupBy('kode_pengisian'));
        // $jumlah = Pengisian::with('penilaian')->where('id_penilaian','=',$id)->get()->count();
        $kriteria = DB::table('kriteria')->join('subkriteria','kriteria.kode_kriteria','=','subkriteria.kode_kriteria')->join('pengisian','subkriteria.kode_subkriteria','=','pengisian.kode_subkriteria')->join('penilaian','pengisian.id_penilaian','=','penilaian.id_penilaian')->where('penilaian.id_penilaian','=',$id)->get()->groupBy('kode_kriteria');
        // dd($kriteria);
        $kriteriatelahdifilter = [];
        foreach ($kriteria as $key => $data) {
            foreach ($data as $key => $value) {
                $tes = json_decode($value->level);
                if (property_exists( $tes, 'guru') ) {
                    array_push($kriteriatelahdifilter, $value);
                }
            }
        }
        $oke = collect($kriteriatelahdifilter)->groupBy('kode_kriteria');
        // dd($oke);
        $data_with_paginate = $this->paginate($oke);
        //set path of pagination
        $data_with_paginate->withPath($tgl);
        // $jumlah = DB::table('kriteria')->get()->count();
        $jumlah = DB::table('kriteria')->join('subkriteria','kriteria.kode_kriteria','=','subkriteria.kode_kriteria')->join('pengisian','subkriteria.kode_subkriteria','=','pengisian.kode_subkriteria')->join('penilaian','pengisian.id_penilaian','=','penilaian.id_penilaian')->groupBy('kriteria.kode_kriteria')->where('penilaian.id_penilaian','=',$id)->get()->count();
        $penilaian = Penilaian::where('id_penilaian','=',$id)->first();
        $tanggal = DB::table('tanggal')->where('id','=',$tgl)->first();
        $coba = [];
        foreach ($data_with_paginate as $keykriteria => $data) {
            foreach ($data as $key => $value) {
                $cek = Pilihan::with('pengisian')->where('kode_pengisian','=',$value->kode_pengisian)->get();
                if (isset($cek)) {
                    
                    $coba[$key] = Pilihan::with('pengisian')->where('kode_pengisian','=',$value->kode_pengisian)->get();
                }
            }
        }
        // dd($coba);
        $hasilpilihan = DB::table('hasilpilihan')->where('user_id','=',Auth::user()->id)->get();
        // dd($hasilpilihan);
        return view('backend/guru.detailkinerjaguru', compact('admin','guru', 'wali','coba','hasilpilihan','jumlah','kriteria','penilaian','tanggal','data_with_paginate'));
    }
    public function paginate($items, $perPage = 1, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
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
            ['tanggal_id','=',$request->tanggal_id],
        ])->count();

        if ($query == 0) {
            $hasilpilihan = new Hasilpilihan;
            // return $request;
            // $pilihan = "answer".$request->input('question');
            $hasilpilihan->kode_pilihan = $request->option_id;
            $hasilpilihan->kode_pengisian = $request->pengisian_id;
            $hasilpilihan->tanggal_id = $request->tanggal_id;
            $hasilpilihan->user_id = Auth::user()->id;
            $hasilpilihan->save();   
        }else {
            Hasilpilihan::where([
            ['user_id','=',Auth::user()->id],
            ['kode_pengisian','=',$request->pengisian_id],
            ['tanggal_id','=',$request->tanggal_id],
        ])->update(['kode_pilihan'=> $request->option_id]);
        }
    }

    public function totalnilai($id,$tgl){
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

            $coba = DB::table('pengisian')->get();
            $nilai = 0;
            $cobatelahdifilter = [];
            foreach ($coba as $key => $value) {
                $tes = json_decode($value->level);
                if (property_exists( $tes, 'guru') && $value->id_penilaian == $id ) {
                    array_push($cobatelahdifilter, $value);
                }
            }
            // dd($cobatelahdifilter);
            foreach ($cobatelahdifilter as $key => $value) {
                $coba1[$key] = DB::table('hasilpilihan')
                ->where('hasilpilihan.kode_pengisian','=',$value->kode_pengisian)
                ->where('user_id','=',Auth::user()->id)
                ->where('tanggal_id','=',$tgl)
                ->join('pilihan','hasilpilihan.kode_pilihan','=','pilihan.kode_pilihan')
                ->join('pengisian','hasilpilihan.kode_pengisian','=','pengisian.kode_pengisian')
                ->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')
                ->join('kriteria','subkriteria.kode_kriteria','=','kriteria.kode_kriteria')
                ->join('pv_subkriteria','subkriteria.kode_subkriteria','=','pv_subkriteria.id_subkriteria')
                ->join('pv_kriteria','kriteria.kode_kriteria','=','pv_kriteria.id_kriteria')->first();
                // dd($coba1);
                if ($coba1[$key] ==  null) {
                    return back()->with('status','Silahkan Jawab Semua Pertanyaan');
                }else {
                    $nilai = $nilai + $coba1[$key]->points * $coba1[$key]->nilai_kriteria * $coba1[$key]->nilai_subkriteria ;   
                }
            }
            
            $bobot = 0.4;
            $query = Hasil::where([
                ['user_id','=',Auth::user()->id],
                ['id_penilaian','=',$id],
                ['tanggal_id','=',$tgl],
            ])->count();
            if ($query == 0) {     
                $total = new Hasil;
                $total->totals = round($nilai,5);
                $total->user_id = Auth::user()->id;
                $total->id_penilaian = $id;
                $total->tanggal_id = $tgl;
                $total->save();
                $queryt = JumlahTotal::where([
                    ['user_id_guru','=',Auth::user()->id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->count();
                $data = JumlahTotal::where([
                    ['user_id_guru','=',Auth::user()->id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->get();
                if ($queryt == 0) {     
                    $total = new JumlahTotal;
                    $total->totals = round(($nilai*$bobot),5);
                    $total->user_id_guru = Auth::user()->id;
                    $total->id_penilaian = $id;
                    $total->tanggal_id = $tgl;
                    $total->save();
                }else {
                    JumlahTotal::where([
                        ['user_id_guru','=',Auth::user()->id],
                        ['id_penilaian','=',$id],
                        ['tanggal_id','=',$tgl],
                    ])->update(['totals'=> round((($nilai*$bobot) + $data[0]->totals),5)]);
                }
                $guru = DB::table('guru')->join('users','guru.user_id','=','users.id')->join('detail_kelas','users.id','=','detail_kelas.user_id')->where('guru.user_id','=',Auth::user()->id)->get();
                if (count($guru) > 0) {
                    $queryt = JumlahWaliTotal::where([
                        ['user_id_guru','=',Auth::user()->id],
                        ['id_penilaian','=',$id],
                        ['tanggal_id','=',$tgl],
                    ])->count();
                    $data = JumlahWaliTotal::where([
                        ['user_id_guru','=',Auth::user()->id],
                        ['id_penilaian','=',$id],
                        ['tanggal_id','=',$tgl],
                    ])->get();
                    if ($queryt == 0) {     
                        $total = new JumlahWaliTotal;
                        $total->totals = round(($nilai*$bobot),5);
                        $total->user_id_guru = Auth::user()->id;
                        $total->id_penilaian = $id;
                        $total->tanggal_id = $tgl;
                        $total->save();
                    }else {
                        JumlahWaliTotal::where([
                            ['user_id_guru','=',Auth::user()->id],
                            ['id_penilaian','=',$id],
                            ['tanggal_id','=',$tgl],
                        ])->update(['totals'=> round((($nilai*$bobot) + $data[0]->totals),5)]);
                    }
                }
            }else {
                $data = JumlahTotal::where([
                    ['user_id_guru','=',Auth::user()->id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->get();
                $dataaa = JumlahWaliTotal::where([
                    ['user_id_guru','=',Auth::user()->id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->get();
                $dataa = Hasil::where([
                    ['user_id','=',Auth::user()->id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->get();
                JumlahTotal::where([
                    ['user_id_guru','=',Auth::user()->id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->update(['totals'=> round((($nilai*$bobot) + (($data[0]->totals/$bobot) - $dataa[0]->totals)),5)]);
                $guru = DB::table('guru')->join('users','guru.user_id','=','users.id')->join('detail_kelas','users.id','=','detail_kelas.user_id')->where('guru.user_id','=',Auth::user()->id)->get();
                if (count($guru) > 0) {
                JumlahWaliTotal::where([
                    ['user_id_guru','=',Auth::user()->id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->update(['totals'=> round((($nilai*$bobot) + (($dataaa[0]->totals/$bobot) - $dataa[0]->totals)),5)]);
                }
                Hasil::where([
                    ['user_id','=',Auth::user()->id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->update(['totals'=> round($nilai,5)]);
            }
            
            // dd($coba1);
            return redirect()->route('penilaiankinerjaguru');
    }
}
