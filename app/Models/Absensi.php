<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $table = 'tb_absensi_kerja';
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}
