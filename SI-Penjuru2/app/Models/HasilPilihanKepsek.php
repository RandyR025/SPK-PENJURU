<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPilihanKepsek extends Model
{
    use HasFactory;
    protected $table = 'hasilpilihankepsek';
    protected $PrimaryKey = 'kode_hasilpilihankepsek';
    protected $fillable = [
        'kode_hasilpilihankepsek',
        'kode_pilihan',
        'kode_pengisian',
        'user_id_kepsek',
        'user_id_guru',
        'id_penilaian',
    ];
}
