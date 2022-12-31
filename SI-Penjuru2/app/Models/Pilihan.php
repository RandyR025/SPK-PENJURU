<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pilihan extends Model
{
    use HasFactory;
    protected $table = 'pilihan';
    protected $PrimaryKey = 'kode_pilihan';
    protected $fillable = [
        'kode_pilihan',
        'kode_pengisian',
        'nama_pilihan',
        'points',
    ];

    public function pengisian(){
        return $this->belongsTo(Pengisian::class);
    }
}
