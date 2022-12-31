<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Guru;
use App\Models\User;
use App\Models\Wali;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DataGuruController extends Controller
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
        return view('backend/admin.data_guru', compact('admin', 'guru', 'wali'));
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
            'name' => 'required|max:32',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4|max:8',
            'level' => 'required',
            'nik' => 'required|unique:guru',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->password);
            $user->level = $request->input('level');
            $user->save();

            if ($user->level == 'admin') {
                $admin = new Admin;
                $admin->user_id = $user->id;
                $admin->nik = $request->nik;
                $admin->tempat_lahir = $request->tempat_lahir;
                $admin->tanggal_lahir = $request->tanggal_lahir;
                $admin->jenis_kelamin = $request->jenis_kelamin;
                $admin->no_telp = $request->no_telp;
                $admin->alamat = $request->alamat;
                $admin->save();
            } elseif ($user->level == 'guru') {
                $guru = new Guru;
                $guru->user_id = $user->id;
                $guru->nik = $request->nik;
                $guru->tempat_lahir = $request->tempat_lahir;
                $guru->tanggal_lahir = $request->tanggal_lahir;
                $guru->jenis_kelamin = $request->jenis_kelamin;
                $guru->no_telp = $request->no_telp;
                $guru->alamat = $request->alamat;
                $guru->save();
            } else {
                $wali = new Wali;
                $wali->user_id = $user->id;
                $wali->nik = $request->nik;
                $wali->tempat_lahir = $request->tempat_lahir;
                $wali->tanggal_lahir = $request->tanggal_lahir;
                $wali->jenis_kelamin = $request->jenis_kelamin;
                $wali->no_telp = $request->no_telp;
                $wali->alamat = $request->alamat;
                $wali->save();
            }

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
        // $guru = Guru::with(['user'])->where('user_id', $id)->get();
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->where('user_id',$id)->get();
        if ($guru) {
            return response()->json([
                'status' => 200,
                'guru' => $guru,
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
            'name' => 'required|max:32',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        } else {
            $user = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->where('user_id',$id);
            if ($user) {
                if ($request->hasFile('image')) {
                    $gambar = DB::table('guru')->where('user_id',$id)->first();
                    File::delete('images/'.$gambar->image);
                    $file = $request->file('image');
                    $extension = $file->getClientOriginalExtension();
                    $filename= time().'.'.$extension;
                    $file->move('images', $filename);
                    $user->update([
                        'name' => $request->name,
                        'nik' => $request->nik,
                        'tanggal_lahir' => $request->tanggal_lahir,
                        'tempat_lahir' => $request->tempat_lahir,
                        'jenis_kelamin' => $request->jenis_kelamin,
                        'alamat' => $request->alamat,
                        'no_telp' => $request->no_telp,
                        'image' => $filename,
                        
                ]);
                } else {
                    $user->update([
                        'name' => $request->name,
                        'nik' => $request->nik,
                        'tanggal_lahir' => $request->tanggal_lahir,
                        'tempat_lahir' => $request->tempat_lahir,
                        'jenis_kelamin' => $request->jenis_kelamin,
                        'alamat' => $request->alamat,
                        'no_telp' => $request->no_telp,
                    ]);
                }
            }
            
            return response()->json([
                'status' => 200,
                'message' => "Data Berhasil Di Perbarui !!!",
            ]);
                    
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
        DB::table('guru')->where('user_id',$id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Berhasil Di Hapus !!!',
        ]);
    }

    public function fetchguru()
    {
        $guru = DB::table('guru')->join('users', 'guru.user_id', '=', 'users.id')->get();
        // $guru = Guru::with(['user'])->get();
        return response()->json([
            'guru' => $guru,
        ]);
    }
}
