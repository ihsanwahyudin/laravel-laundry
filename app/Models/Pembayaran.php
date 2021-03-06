<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'tb_pembayaran';
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function detailPembayaran()
    {
        return $this->hasMany(DetailPembayaran::class, 'pembayaran_id');
    }
}
