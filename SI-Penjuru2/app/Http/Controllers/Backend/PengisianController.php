<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pengisian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengisianController extends Controller
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
        return view('backend/admin.data_pengisian', compact('admin','guru', 'wali'));
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
        $validator = Validator::make($request->all(), [
            'id_penilaian' => 'required|max:10',
            'kode_pengisian' => 'required|max:10|unique:pengisian'
            
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $pengisian = new Pengisian;
            $pengisian->id_penilaian = $request->input('id_penilaian');
            $pengisian->kode_pengisian = $request->input('kode_pengisian');
            $pengisian->nama_pengisian = $request->input('nama_pengisian');
            $pengisian->kode_subkriteria = $request->input('kode_subkriteria');
            $pengisian->save();

            return response()->json([
                'status' => 200,
                'message' => "Data Berhasil Di Tambahkan !!!",
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pengisian = DB::table('pengisian')->join('penilaian', 'pengisian.id_penilaian', '=', 'penilaian.id_penilaian')->where('penilaian.id_penilaian',$id)->join('subkriteria', 'pengisian.kode_subkriteria', '=', 'subkriteria.kode_subkriteria')->get();
        $penilaian = DB::table('penilaian')->where('id_penilaian', $id)->get();
        $kriteria = DB::table('kriteria')->get();
        $subkriteria = DB::table('subkriteria')->get();
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);
        $no = 1;
        // dd($pengisian);
        return view('backend/admin.data_pengisian', compact('admin','guru', 'wali', 'pengisian', 'no', 'penilaian','subkriteria','kriteria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pengisian = DB::table('pengisian')->where('pengisian.kode_pengisian',$id)->get();
        if ($pengisian) {
            return response()->json([
                'status' => 200,
                'pengisian' => $pengisian,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'User Not Found',
            ]);
        }
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
        $validator = Validator::make($request->all(), [
            'kode_pengisian' => 'required',
            'nama_pengisian' => 'required',
            'kode_subkriteria' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $pengisian = DB::table('pengisian')->where('pengisian.kode_pengisian',$id);
            if ($pengisian) {
                $pengisian->update([
                    'kode_pengisian' => $request->kode_pengisian,
                    'nama_pengisian' => $request->nama_pengisian,
                    'kode_subkriteria' => $request->kode_subkriteria,
                
                
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => "Data Berhasil Di Perbarui !!!",
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'User Not Found',
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('pengisian')->where('kode_pengisian',$id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }

    public function getSubkriteria($id){
        $subkriteria = DB::table('subkriteria')->where('kode_kriteria','=',$id)->get();
        return response()->json(['subkriteria'=>$subkriteria]);
    }
}
