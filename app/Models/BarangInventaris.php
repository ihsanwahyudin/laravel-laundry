<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangInventaris extends Model
{
    use HasFactory;

    protected $table = 'tb_barang_inventaris';
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}
