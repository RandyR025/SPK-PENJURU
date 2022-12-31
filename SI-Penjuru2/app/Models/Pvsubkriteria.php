<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pvsubkriteria extends Model
{
    use HasFactory;
    protected $table = 'pv_subkriteria';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id_subkriteria',
        'nilai_subkriteria',
        'id_kriteria',
    ];
}
