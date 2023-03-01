<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserExcelImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row)
        {
           $user = User::create([
               'name' => $row['name'],
               'email'    => $row['email'],
               'password' => Hash::make('password'),
               'level' => 'guru',
               'id' => $row['no'],
           ]);
           Guru::create([
               'nik' => $row['nik'],
               'tempat_lahir' => $row['tempat_lahir'],
               'tanggal_lahir' => $row['tanggal_lahir'],
               'jenis_kelamin' => $row['jenis_kelamin'],
               'no_telp' => $row['no_telp'],
               'alamat' => $row['alamat'],
               'user_id' => $user->id,
           ]);
           
      }
    }
}
