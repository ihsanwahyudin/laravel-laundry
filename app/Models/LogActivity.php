<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    protected $table = 'tb_log_activity';
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function detailLogActivity()
    {
        return $this->hasMany(DetailLogActivity::class, 'log_activity_id', 'id');
    }

    public function referenceTable()
    {
        return $this->belongsTo(ListTable::class, 'reference_table_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
