<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perbandingansubkriteria extends Model
{
    use HasFactory;
    protected $table = 'perbandingan_subkriteria';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'subkriteria_pertama',
        'value',
        'subkriteria_kedua',
        'id_kriteria',
    ];
}
