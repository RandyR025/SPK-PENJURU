<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    use HasFactory;
    protected $table = 'hasil';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'totals',
        'user_id',
        'id_penilaian',
    ];
}
