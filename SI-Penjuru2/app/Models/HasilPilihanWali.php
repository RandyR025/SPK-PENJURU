<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPilihanWali extends Model
{
    use HasFactory;
    protected $table = 'hasilpilihanwali';
    protected $PrimaryKey = 'kode_hasilpilihanwali';
    protected $fillable = [
        'kode_hasilpilihanwali',
        'kode_pilihan',
        'kode_pengisian',
        'user_id_wali',
        'user_id_guru',
        'id_penilaian',
    ];
}
