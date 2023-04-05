<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilKepsek extends Model
{
    use HasFactory;
    protected $table = 'hasilkepsek';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'totals',
        'user_id_kepsek',
        'user_id_guru',
        'id_penilaian',
    ];
}
