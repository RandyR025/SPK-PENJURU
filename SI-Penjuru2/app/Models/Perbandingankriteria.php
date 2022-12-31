<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perbandingankriteria extends Model
{
    use HasFactory;
    protected $table = 'perbandingan_kriteria';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'kriteria_pertama',
        'value',
        'kriteria_kedua',
    ];
}
