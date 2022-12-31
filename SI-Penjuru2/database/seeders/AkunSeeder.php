<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'level' => 'admin',
            'password' => Hash::make('admin123'),
        ],

        [
            'id' => 2,
            'name' => 'guru',
            'email' => 'guru@gmail.com',
            'level' => 'guru',
            'password' => Hash::make('guru123'),
        ],

        [
            'id' => 3,
            'name' => 'wali',
            'email' => 'wali@gmail.com',
            'level' => 'wali',
            'password' => Hash::make('wali123'),
        ],
        [
            'id' => 4,
            'name' => 'Abdul Yasid, S.Pd',
            'email' => 'abdulyasid92@gmail.com',
            'level' => 'guru',
            'password' => Hash::make('guru123'),
        ],
        [
            'id' => 5,
            'name' => 'Ahmad Fauzan Awaris,S.Sos',
            'email' => 'afauzanaw@gmail.com',
            'level' => 'guru',
            'password' => Hash::make('guru123'),
        ],
        [
            'id' => 6,
            'name' => 'Ahmad Najib Syarifudin',
            'email' => 'cahlamongan27@gmail.com',
            'level' => 'guru',
            'password' => Hash::make('guru123'),
        ],
        [
            'id' => 7,
            'name' => 'Elly Nuzulianti, S.S.',
            'email' => 'ellysdit@gmail.com ',
            'level' => 'guru',
            'password' => Hash::make('guru123'),
        ],
        [
            'id' => 8,
            'name' => 'Siti Oktafiani,S.Pd.',
            'email' => 'sitioktaviani111@gmail.com',
            'level' => 'guru',
            'password' => Hash::make('guru123'),
        ],
        ];
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
