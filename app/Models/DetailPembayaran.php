<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembayaran extends Model
{
    use HasFactory;
    protected $table = 'tb_detail_pembayaran';
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'pembayaran_id');
    }
}
