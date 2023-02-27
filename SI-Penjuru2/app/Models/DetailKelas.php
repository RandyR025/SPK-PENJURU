<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKelas extends Model
{
    use HasFactory;
    protected $table = 'detail_kelas';
    protected $PrimaryKey = 'kode_detail_kelas';
    protected $fillable = [
        'kode_detail_kelas',
        'kode_kelas',
        'user_id',
    ];
}
