<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IR extends Model
{
    use HasFactory;
    protected $table = 'ir';
    protected $PrimaryKey = 'id';
    protected $fillable = [
        'jumlah',
        'nilai',
    ];
}
