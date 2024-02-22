<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPackagingInspect extends Model
{
    use HasFactory;
    protected $fillable = [
        'ins_template_name',
        'ins_topic',
        'ins_method',
        'sequence',
        'ins_type',
        'packaging_inspect_id',
        'packaging_lot_id',
    ];
}
