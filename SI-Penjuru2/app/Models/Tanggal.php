<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanggal extends Model
{
    use HasFactory;
    protected $table = 'tanggal';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'id_penilaian',
        'tanggal',
        'deadline',
    ];
}
