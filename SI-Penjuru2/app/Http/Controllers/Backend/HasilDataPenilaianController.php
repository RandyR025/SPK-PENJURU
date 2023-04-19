<?php

namespace App\Http\Controllers\Backend;

use App\Exports\HasilPenilaianExcelExport;
use App\Http\Controllers\Controller;
use App\Models\Hasil;
use App\Models\Hasilpilihan;
use App\Models\Pengisian;
use App\Models\Pilihan;
use App\Models\Penilaian;
use App\Models\JumlahTotal;
use App\Models\JumlahWaliTotal;
// use Barryvdh\DomPDF\PDF;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class HasilDataPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $firstmonth = $request->get('firstmonth');
        $lastmonth = $request->get('lastmonth');
        $firstyear = $request->get('firstyear');
        $lastyear = $request->get('lastyear');
        if (isset($firstmonth) && isset($lastmonth) && isset($firstyear) && isset($lastyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'tanggal.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal','>=',$firstmonth)->whereMonth('tanggal','<=',$lastmonth)->whereYear('tanggal','>=',$firstyear)->whereYear('tanggal','<=',$lastyear)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($firstyear) && isset($lastyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'tanggal.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereYear('tanggal','>=',$firstyear)->whereYear('tanggal','<=',$lastyear)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($firstmonth) && isset($lastmonth)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'tanggal.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal','>=',$firstmonth)->whereMonth('tanggal','<=',$lastmonth)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($firstmonth) && isset($firstyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'tanggal.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal','=',$firstmonth)->whereYear('tanggal','=',$firstyear)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($firstmonth) && isset($lastyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'tanggal.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal','=',$firstmonth)->whereYear('tanggal','=',$lastyear)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($lastmonth) && isset($firstyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'tanggal.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal','=',$lastmonth)->whereYear('tanggal','=',$firstyear)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($lastmonth) && isset($lastyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'tanggal.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal','=',$firstmonth)->whereYear('tanggal','=',$lastyear)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($firstmonth)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'tanggal.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal','=',$firstmonth)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($lastmonth)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'tanggal.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereMonth('tanggal','=',$lastmonth)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($firstyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'tanggal.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereYear('tanggal','=',$firstyear)->groupBy('jumlah_total.tanggal_id')->get();
        }elseif (isset($lastyear)) {
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'tanggal.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->whereYear('tanggal','=',$lastyear)->groupBy('jumlah_total.tanggal_id')->get();
        }else{
            $penilaian = DB::table('jumlah_total')->join('tanggal', 'jumlah_total.tanggal_id', '=', 'tanggal.id')->join('penilaian', 'tanggal.id_penilaian', '=', 'penilaian.id_penilaian')->select('penilaian.id_penilaian', DB::raw('count(*) as jumlah'), 'penilaian.nama_penilaian','tanggal.tanggal','penilaian.image','tanggal.id')->groupBy('jumlah_total.tanggal_id')->get();
        }
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);
        // dd($penilaian);
        return view('backend/admin.hasil_data_penilaian', compact('admin','guru', 'wali','penilaian'));
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
        $hasil = DB::table('hasil')->join('users', 'hasil.user_id','=','users.id')->join('penilaian','hasil.id_penilaian','=','penilaian.id_penilaian')->where('penilaian.id_penilaian','=',$id)->get();
        // $pengisian = collect(DB::table('pilihan')->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->where('penilaian.id_penilaian',$id)->join('subkriteria', 'pengisian.kode_subkriteria', '=', 'subkriteria.kode_subkriteria')->join('kriteria', 'subkriteria.kode_kriteria', '=', 'kriteria.kode_kriteria')->get()->groupBy('kode_pengisian'));
        // dd($hasil);
        $penilaian = DB::table('penilaian')->where('id_penilaian', $id)->get();
        $no = 1;
        // $coba1 = Pengisian::with('penilaian')->where('id_penilaian','=',$id)->get();
        // foreach ($coba1 as $key => $value) {
        //     $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan','=','pilihan.kode_pilihan')->where('hasilpilihan.kode_pengisian','=',$value->kode_pengisian)->join('pengisian','pilihan.kode_pengisian','=','pengisian.kode_pengisian')->get();
        // }
        $coba = [];
        $coba1 = DB::table('users')->join('hasil','users.id','=','hasil.user_id')->where('hasil.id_penilaian','=',$id)->where('hasil.tanggal_id','=',$tgl)->get();
        foreach ($coba1 as $key => $value) {
            $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan','=','pilihan.kode_pilihan')->where('hasilpilihan.user_id','=',$value->user_id)->join('pengisian','pilihan.kode_pengisian','=','pengisian.kode_pengisian')->where('pengisian.id_penilaian', '=', $id)->where('hasilpilihan.tanggal_id', '=', $tgl)->get();
        }
        $pengisian = DB::table('pengisian')->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')->where('id_penilaian','=',$id)->get();
        // dd($coba1);
        return view('backend/admin.hasil_penilaian', compact('admin','guru', 'wali','hasil','no','penilaian','coba1','coba','pengisian'));
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
    public function destroy($id,$pen)
    {
        DB::table('hasil')->where([['user_id','=',$id],['id_penilaian','=',$pen],])->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }

    public function cek($id,$pen,$tgl){
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);

        // $pengisian = collect(DB::table('pilihan')->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->where('penilaian.id_penilaian',$id)->join('subkriteria', 'pengisian.kode_subkriteria', '=', 'subkriteria.kode_subkriteria')->join('kriteria', 'subkriteria.kode_kriteria', '=', 'kriteria.kode_kriteria')->get()->groupBy('kode_pengisian'));
        $kriteria = DB::table('kriteria')->join('subkriteria','kriteria.kode_kriteria','=','subkriteria.kode_kriteria')->join('pengisian','subkriteria.kode_subkriteria','=','pengisian.kode_subkriteria')->join('penilaian','pengisian.id_penilaian','=','penilaian.id_penilaian')->where('penilaian.id_penilaian','=',$pen)->get()->groupBy('kode_kriteria');
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
        $jumlah = DB::table('kriteria')->join('subkriteria','kriteria.kode_kriteria','=','subkriteria.kode_kriteria')->join('pengisian','subkriteria.kode_subkriteria','=','pengisian.kode_subkriteria')->join('penilaian','pengisian.id_penilaian','=','penilaian.id_penilaian')->groupBy('kriteria.kode_kriteria')->where('penilaian.id_penilaian','=',$pen)->get()->count();
        // $jumlah = Pengisian::with('penilaian')->where('id_penilaian','=',$pen)->get()->count();
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
        $user = DB::table('users')->where('id','=',$id)->get();
        $hasilpilihan = DB::table('hasilpilihan')->where('user_id','=',$id)->get();
        // dd($hasilpilihan);
        return view('backend/admin.hasil_cek', compact('admin','guru', 'wali','coba','hasilpilihan','jumlah','user','kriteria','penilaian','tanggal','data_with_paginate'));   
    }

    public function paginate($items, $perPage = 1, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public function hasilcek(Request $request){
            // return $request;
        $query = Hasilpilihan::where([
            ['user_id','=',$request->user_id],
            ['kode_pengisian','=',$request->pengisian_id],
            ['tanggal_id','=',$request->tanggal_id],
        ])->count();

        if ($query == 0) {
            $hasilpilihan = new Hasilpilihan;
            // return $request;
            // $pilihan = "answer".$request->input('question');
            $hasilpilihan->kode_pilihan = $request->option_id;
            $hasilpilihan->kode_pengisian = $request->pengisian_id;
            $hasilpilihan->user_id = $request->user_id;
            $hasilpilihan->tanggal_id = $request->tanggal_id;
            $hasilpilihan->save();   
        }else {
            Hasilpilihan::where([
            ['user_id','=',$request->user_id],
            ['kode_pengisian','=',$request->pengisian_id],
            ['tanggal_id','=',$request->tanggal_id],
        ])->update(['kode_pilihan'=> $request->option_id]);
        }
    }

    public function totalnilai($id,$user_id,$tgl){
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
            foreach ($cobatelahdifilter as $key => $value) {
                $coba1[$key] = DB::table('hasilpilihan')
                ->where('hasilpilihan.kode_pengisian','=',$value->kode_pengisian)
                ->where('user_id','=',$user_id)
                ->where('tanggal_id','=',$tgl)
                ->join('pilihan','hasilpilihan.kode_pilihan','=','pilihan.kode_pilihan')
                ->join('pengisian','hasilpilihan.kode_pengisian','=','pengisian.kode_pengisian')
                ->join('subkriteria','pengisian.kode_subkriteria','=','subkriteria.kode_subkriteria')
                ->join('kriteria','subkriteria.kode_kriteria','=','kriteria.kode_kriteria')
                ->join('pv_subkriteria','subkriteria.kode_subkriteria','=','pv_subkriteria.id_subkriteria')
                ->join('pv_kriteria','kriteria.kode_kriteria','=','pv_kriteria.id_kriteria')->first();
                $nilai = $nilai + $coba1[$key]->points * $coba1[$key]->nilai_kriteria * $coba1[$key]->nilai_subkriteria ;   
            }
            

            $bobot = 0.4;
            $query = Hasil::where([
                ['user_id','=',$user_id],
                ['id_penilaian','=',$id],
                ['tanggal_id','=',$tgl],
            ])->count();
            if ($query == 0) {     
                $total = new Hasil;
                $total->totals = round($nilai,5);
                $total->user_id = $user_id;
                $total->id_penilaian = $id;
                $total->tanggal_id = $tgl;
                $total->save();
                $queryt = JumlahTotal::where([
                    ['user_id_guru','=',$user_id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->count();
                $data = JumlahTotal::where([
                    ['user_id_guru','=',$user_id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->get();
                if ($queryt == 0) {     
                    $total = new JumlahTotal;
                    $total->totals = round(($nilai*$bobot),5);
                    $total->user_id_guru = $user_id;
                    $total->id_penilaian = $id;
                    $total->tanggal_id = $tgl;
                    $total->save();
                }else {
                    JumlahTotal::where([
                        ['user_id_guru','=',$user_id],
                        ['id_penilaian','=',$id],
                        ['tanggal_id','=',$tgl],
                    ])->update(['totals'=> round((($nilai*$bobot) + $data[0]->totals),5)]);
                }
                $guru = DB::table('guru')->join('users','guru.user_id','=','users.id')->join('detail_kelas','users.id','=','detail_kelas.user_id')->where('guru.user_id','=',$user_id)->get();
                if (count($guru) > 0) {
                    $queryt = JumlahWaliTotal::where([
                        ['user_id_guru','=',$user_id],
                        ['id_penilaian','=',$id],
                        ['tanggal_id','=',$tgl],
                    ])->count();
                    $data = JumlahWaliTotal::where([
                        ['user_id_guru','=',$user_id],
                        ['id_penilaian','=',$id],
                        ['tanggal_id','=',$tgl],
                    ])->get();
                    if ($queryt == 0) {     
                        $total = new JumlahWaliTotal;
                        $total->totals = round(($nilai*$bobot),5);
                        $total->user_id_guru = $user_id;
                        $total->id_penilaian = $id;
                        $total->tanggal_id = $tgl;
                        $total->save();
                    }else {
                        JumlahWaliTotal::where([
                            ['user_id_guru','=',$user_id],
                            ['id_penilaian','=',$id],
                            ['tanggal_id','=',$tgl],
                        ])->update(['totals'=> round((($nilai*$bobot) + $data[0]->totals),5)]);
                    }
                }
            }else {
                $data = JumlahTotal::where([
                    ['user_id_guru','=',$user_id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->get();
                $dataaa = JumlahWaliTotal::where([
                    ['user_id_guru','=',$user_id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->get();
                $dataa = Hasil::where([
                    ['user_id','=',$user_id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->get();
                JumlahTotal::where([
                    ['user_id_guru','=',$user_id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->update(['totals'=> round((($nilai*$bobot) + ($data[0]->totals - ($dataa[0]->totals * $bobot))),5)]);
                $guru = DB::table('guru')->join('users','guru.user_id','=','users.id')->join('detail_kelas','users.id','=','detail_kelas.user_id')->where('guru.user_id','=',$user_id)->get();
                if (count($guru) > 0) {
                JumlahWaliTotal::where([
                    ['user_id_guru','=',$user_id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->update(['totals'=> round((($nilai*$bobot) + ($dataaa[0]->totals - ($dataa[0]->totals * $bobot))),5)]);
                }
                Hasil::where([
                    ['user_id','=',$user_id],
                    ['id_penilaian','=',$id],
                    ['tanggal_id','=',$tgl],
                ])->update(['totals'=> round($nilai,5)]);
            }
            
            // dd($coba1);
            return redirect()->route('hasilpenilaian',[$id,$tgl]);
    }
    public function cetak_pdf($id){
        $hasil = DB::table('hasil')->join('users', 'hasil.user_id','=','users.id')->join('penilaian','hasil.id_penilaian','=','penilaian.id_penilaian')->where('penilaian.id_penilaian','=',$id)->get();
        // $pengisian = collect(DB::table('pilihan')->join('pengisian', 'pilihan.kode_pengisian', '=', 'pengisian.kode_pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->where('penilaian.id_penilaian',$id)->join('subkriteria', 'pengisian.kode_subkriteria', '=', 'subkriteria.kode_subkriteria')->join('kriteria', 'subkriteria.kode_kriteria', '=', 'kriteria.kode_kriteria')->get()->groupBy('kode_pengisian'));
        // dd($hasil);
        $penilaian = DB::table('penilaian')->where('id_penilaian', $id)->get();
        $no = 1;
        // $coba1 = Pengisian::with('penilaian')->where('id_penilaian','=',$id)->get();
        // foreach ($coba1 as $key => $value) {
        //     $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan','=','pilihan.kode_pilihan')->where('hasilpilihan.kode_pengisian','=',$value->kode_pengisian)->join('pengisian','pilihan.kode_pengisian','=','pengisian.kode_pengisian')->get();
        // }
        $coba1 = DB::table('users')->join('hasil','users.id','=','hasil.user_id')->where('hasil.id_penilaian','=',$id)->get();
        foreach ($coba1 as $key => $value) {
            $coba[$key] = DB::table('hasilpilihan')->join('pilihan', 'hasilpilihan.kode_pilihan','=','pilihan.kode_pilihan')->where('hasilpilihan.user_id','=',$value->user_id)->join('pengisian','pilihan.kode_pengisian','=','pengisian.kode_pengisian')->where('pengisian.id_penilaian','=',$id)->get();
        }
        $pengisian = DB::table('pengisian')->where('id_penilaian','=',$id)->get();
        $pengisiantelahdifilter = [];
        foreach ($pengisian as $key => $value) {
                $tes = json_decode($value->level);
                if (property_exists( $tes, 'guru') ) {
                    array_push($pengisiantelahdifilter, $value);
            }
        }
        $pdf = PDF::loadview('backend/admin.hasilpenilaian_pdf',['coba'=>$coba, 'coba1'=>$coba1, 'penilaian'=>$penilaian, 'pengisian'=>$pengisiantelahdifilter, 'no'=>$no ,'data'=>'Laporan Hasil Jawaban Penilaian']);
        return $pdf->stream('laporan-hasil-penilaian');
    }
    public function eksport_excel($id){
        return Excel::download(new HasilPenilaianExcelExport($id),'penilaian.xlsx');
    }
}
