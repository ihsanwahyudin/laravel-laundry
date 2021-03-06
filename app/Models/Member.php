<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'tb_member';
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'member_id', 'id');
    }
}
