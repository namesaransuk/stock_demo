<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryMaterialInspectDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'ins_times',
        'ins_qty',
        'detail',
        'material_lot_id',
        'history_material_inspect_id',
        'material_inspect_id',
        'audit_user_id',
    ];
}
