<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailLogActivity extends Model
{
    use HasFactory;

    protected $table = 'tb_detail_log_activity';
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function tableColumnList()
    {
        return $this->belongsTo(TableColumnList::class, 'table_column_lists_id', 'id');
    }
}
