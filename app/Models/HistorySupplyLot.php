<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorySupplyLot extends Model
{
    use HasFactory;
    protected $fillable = [
        'lot',
        'qty',
        'mfg',
        'exp',
        'action',
        'company_id',
        'receive_supply_id',
        'supply_id',
        'history_receive_supply_id',
    ];

    public function supply(){
        return $this->belongsTo(Supply::class,'supply_id');
    }

    public function receiveSupply(){
        return $this->belongsTo(ReceiveSupply::class,'receive_supply_id');
    }

    public function supplyCuts(){
        return $this->hasMany(SupplyCut::class,'supply_lot_id');
    }

    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
}
