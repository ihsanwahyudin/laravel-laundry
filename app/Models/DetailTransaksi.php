<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'tb_detail_transaksi';
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}
