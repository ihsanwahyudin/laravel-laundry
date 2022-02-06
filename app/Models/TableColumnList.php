<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableColumnList extends Model
{
    use HasFactory;

    protected $table = 'table_column_lists';
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}
