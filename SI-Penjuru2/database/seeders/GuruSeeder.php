<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guru = [
            [
            'nik' => 3509161207910000,
            'tempat_lahir' => 'Jember',
            'tanggal_lahir' => '1991-07-12',
            'jenis_kelamin' => 'laki-laki',
            'no_telp' => '082132950649',
            'alamat' => 'Dusun krajan rt/rw 004/002 desa cangkring, kecamatan jenggawah kabupaten jember',
            'user_id' => 4
        ],
        [
            'nik' => 3528130511880000,
            'tempat_lahir' => 'Pamekasan',
            'tanggal_lahir' => '1988-11-05',
            'jenis_kelamin' => 'laki-laki',
            'no_telp' => '085259691432',
            'alamat' => 'jln branjangan, ling. semengguRt01/Rw04 Bintoro Patrang',
            'user_id' => 5
        ],
        [
            'nik' => 3524032702930000,
            'tempat_lahir' => 'Lamongan',
            'tanggal_lahir' => '1993-02-27',
            'jenis_kelamin' => 'laki-laki',
            'no_telp' => '085785130378',
            'alamat' => 'Jln Ngelo Rt 03/Rw05 Jatipayak Kecamatan Modo Lamongan',
            'user_id' => 6
        ],
        [
            'nik' => 3509214211700010,
            'tempat_lahir' => 'Pekalongan',
            'tanggal_lahir' => '1970-11-02',
            'jenis_kelamin' => 'perempuan',
            'no_telp' => '082139254400',
            'alamat' => 'Jl Tawang Mangu 6 No 5',
            'user_id' => 7
        ],
        [
            'nik' => 3510036710970010,
            'tempat_lahir' => 'Banyuwangi',
            'tanggal_lahir' => '1997-10-27',
            'jenis_kelamin' => 'perempuan',
            'no_telp' => '082140345830',
            'alamat' => 'Jl. Gajah Mada gang 29/31 Kaliwates Jember, kaliwates',
            'user_id' => 8
        ],
    ];
    foreach ($guru as $key => $value) {
        Guru::create($value);
    }
    }
}
