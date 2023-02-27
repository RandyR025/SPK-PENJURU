<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JumlahTotal extends Model
{
    use HasFactory;
    protected $table = 'jumlah_total';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'totals',
        'id_penilaian',
        'user_id_guru',
    ];
}
