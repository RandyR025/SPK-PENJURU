<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Guru;
use App\Models\Wali;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserExcelImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
     * @param Collection $collection
     */

    public function __construct($akses)
    {
        $this->akses = $akses;
    }
    public function collection(Collection $collection)
    {
        if ($this->akses == 'guru') {
            foreach ($collection as $row) {
                $user = User::create([
                    'name' => $row['name'],
                    'email'    => $row['email'],
                    'password' => Hash::make('password'),
                    'level' => 'guru',
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
        }elseif ($this->akses == 'wali') {
            foreach ($collection as $row)
            {
               $user = User::create([
                   'name' => $row['name'],
                   'email'    => $row['email'],
                   'password' => Hash::make('password'),
                   'level' => 'wali',
               ]);
               Wali::create([
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
    public function rules():array{
        return[
            '*.email' => ['email','unique:users,email']
        ];
    }
}
