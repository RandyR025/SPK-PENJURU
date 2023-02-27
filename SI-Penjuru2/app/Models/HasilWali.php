<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilWali extends Model
{
    use HasFactory;
    protected $table = 'hasilwali';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'totals',
        'user_id_wali',
        'user_id_guru',
        'id_penilaian',
    ];
}
