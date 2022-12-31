<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pvkriteria extends Model
{
    use HasFactory;
    protected $table = 'pv_kriteria';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id_kriteria',
        'nilai_kriteria',
    ];
}
