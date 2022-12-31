<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasilpilihan extends Model
{
    use HasFactory;
    protected $table = 'hasilpilihan';
    protected $PrimaryKey = 'kode_hasilpilihan';
    protected $fillable = [
        'kode_hasilpilihan',
        'kode_pilihan',
        'kode_pengisian',
        'user_id',
        'id_penilaian',
    ];
}
