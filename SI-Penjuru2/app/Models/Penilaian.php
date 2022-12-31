<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;
    protected $table = 'penilaian';
    protected $PrimaryKey = 'id_penilaian';
    protected $fillable = [
        'id_penilaian',
        'nama_penilaian',
    ];


    public function pengisian(){
        return $this->hasMany(Pengisian::class);
    }
}
