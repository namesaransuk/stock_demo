<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorySupplyCut extends Model
{
    use HasFactory;
    protected $fillable = [
        'datetime',
        'action',
        'qty',
        'created_by',
        'updated_by',
        'supply_lot_id',
        'requsition_supply_id',
        'history_requsition_supply_id',
    ];

    public function supplyLot(){
        return $this->belongsTo(SupplyLot::class,'supply_lot_id');
    }
}
