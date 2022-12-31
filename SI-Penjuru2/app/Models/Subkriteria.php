<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subkriteria extends Model
{
    use HasFactory;
    protected $table = 'subkriteria';
    protected $PrimaryKey = 'kode_subkriteria';
    protected $fillable = [
        'kode_kriteria',
        'kode_subkriteria',
        'nama_subkriteria',
    ];
}
