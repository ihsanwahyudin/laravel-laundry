<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListTable extends Model
{
    use HasFactory;

    protected $table = 'list_table';
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function columnList()
    {
        return $this->hasMany(TableColumnList::class, 'list_table_id', 'id');
    }
}
