<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logging extends Model
{
    use HasFactory;
    protected $table = 'tb_logging';
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}
