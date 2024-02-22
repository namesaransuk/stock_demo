<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyCut extends Model
{
    use HasFactory;
    protected $fillable = [
        'action',
        'datetime',
        'qty',
        'supply_lot_id',
        'requsition_supply_id',
        'created_by',
        'updated_by',
        'reserve',
        'inventory_approve',
    ];

    //IN [FK]
    public function supplyLot(){
        return $this->belongsTo(SupplyLot::class,'supply_lot_id');
    }

    public function requsitionSupply(){
        return $this->belongsTo(RequsitionSupply::class,'requsition_supply_id');
    }
    //OUT [PK]
}
