<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryMaterialCutReturn extends Model
{
    use HasFactory;
    protected $fillable = [
        'datetime',
        'weight',
        'action',
        'material_lot_id',
        'requsition_material_id',
        'create_date',
        'update_date',
        'history_requsition_material_id',
        'claim_flag',
        'stock_accept',
        "created_by",
        "updated_by",
    ];
    public function materialLot(){
        return $this->belongsTo(MaterialLot::class,'material_lot_id');
    }
}
