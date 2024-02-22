<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyLot extends Model
{
    use HasFactory;
    protected $fillable = [
        'lot',
        'qty',
        'mfg',
        'exp',
        'action',
        'receive_supply_id',
        'supply_id',
        'company_id',
    ];

    public function supply(){
        return $this->belongsTo(Supply::class,'supply_id');
    }

    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }

    public function receiveSupply(){
        return $this->belongsTo(ReceiveSupply::class,'receive_supply_id');
    }

    public function supplyCuts(){
        return $this->hasMany(SupplyCut::class,'supply_lot_id');
    }

    protected $appends = ['check_qty'];
    public function getCheckQtyAttribute()
    {
        $qty = $this->reject_status;
            if ($qty == 0) {
                $qty_text = "ปกติ";
            }else if($qty == 1){
                $qty_text = "ตีกลับ";
            };
        return $qty_text;
    }
}
