<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryMaterialInspect extends Model
{
    use HasFactory;
    protected $fillable = [
        'ins_template_name',
        'ins_topic',
        'ins_method',
        'sequence',
        'ins_type',
        'material_inspect_id',
        'material_lot_id',
    ];
}
