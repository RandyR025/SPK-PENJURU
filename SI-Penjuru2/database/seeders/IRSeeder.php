<?php

namespace Database\Seeders;

use App\Models\IR;
use Illuminate\Database\Seeder;

class IRSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ir =[
            [
                'id' => 1,
                'jumlah' => 1,
                'nilai' => 0,

            ],
            [
                'id' => 2,
                'jumlah' => 2,
                'nilai' => 0,
            ],
            [
                'id' => 3,
                'jumlah' => 3,
                'nilai' => 0.58,
            ],
            [
                'id' => 4,
                'jumlah' => 4,
                'nilai' => 0.9,
            ],
            [
                'id' => 5,
                'jumlah' => 5,
                'nilai' => 1.12,
            ],
            [
                'id' => 6,
                'jumlah' => 6,
                'nilai' => 1.24,
            ],
            [
                'id' => 7,
                'jumlah' => 7,
                'nilai' => 1.32,
            ],
            [
                'id' => 8,
                'jumlah' => 8,
                'nilai' => 1.41,
            ],
            [
                'id' => 9,
                'jumlah' => 9,
                'nilai' => 1.45,
            ],
            [
                'id' => 10,
                'jumlah' => 10,
                'nilai' => 1.49,
            ],
            [
                'id' => 11,
                'jumlah' => 11,
                'nilai' => 1.51,
            ],
            [
                'id' => 12,
                'jumlah' => 12,
                'nilai' => 1.48,
            ],
            [
                'id' => 13,
                'jumlah' => 13,
                'nilai' => 1.56,
            ],
            [
                'id' => 14,
                'jumlah' => 14,
                'nilai' => 1.57,
            ],
            [
                'id' => 15,
                'jumlah' => 15,
                'nilai' => 1.59,
            ],
        ];
        foreach ($ir as $key => $value) {
            IR::create($value);
        }
    }
}
