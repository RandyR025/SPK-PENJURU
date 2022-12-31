<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Subkriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubkriteriaController extends Controller
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
        return view('backend/admin.data_subkriteria', compact('admin','guru', 'wali'));
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
            'kode_kriteria' => 'required|max:10',
            'kode_subkriteria' => 'required|max:10|unique:subkriteria'
            
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $subkriteria = new Subkriteria;
            $subkriteria->kode_kriteria = $request->input('kode_kriteria');
            $subkriteria->kode_subkriteria = $request->input('kode_subkriteria');
            $subkriteria->nama_subkriteria = $request->input('nama_subkriteria');
            $subkriteria->save();

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
        $subkriteria = DB::table('subkriteria')->join('kriteria', 'subkriteria.kode_kriteria', '=', 'kriteria.kode_kriteria')->where('kriteria.kode_kriteria',$id)->get();
        $kriteria = DB::table('kriteria')->where('kode_kriteria', $id)->get();
        $admin = DB::table('admin')->join('users', 'admin.user_id', '=', 'users.id')->find(Auth::user()->id);
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->find(Auth::user()->id);
        $wali = DB::table('wali')->join('users', 'wali.user_id', '=', 'users.id')->find(Auth::user()->id);
        $no = 1;
        return view('backend/admin.data_subkriteria', compact('admin','guru', 'wali', 'subkriteria', 'no', 'kriteria'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subkriteria = DB::table('subkriteria')->where('subkriteria.kode_subkriteria',$id)->get();
        if ($subkriteria) {
            return response()->json([
                'status' => 200,
                'subkriteria' => $subkriteria,
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
            'kode_subkriteria' => 'required',
            'nama_subkriteria' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $subkriteria = DB::table('subkriteria')->where('subkriteria.kode_subkriteria',$id);
            if ($subkriteria) {
                $subkriteria->update([
                    'kode_subkriteria' => $request->kode_subkriteria,
                    'nama_subkriteria' => $request->nama_subkriteria,
                
                
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
        DB::table('subkriteria')->where('kode_subkriteria',$id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }


    public function fetchsubkriteria($id)
    {
        $subkriteria = DB::table('subkriteria')->join('kriteria', 'subkriteria.kode_kriteria', '=', 'kriteria.kode_kriteria')->where('kriteria.kode_kriteria',$id)->get();
        return response()->json([
            'subkriteria' => $subkriteria,
        ]);
    }
}
