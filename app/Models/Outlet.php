<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;
    
    protected $table = 'tb_outlet';
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}
