<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPackagingLot extends Model
{
    use HasFactory;
    protected $fillable = [
        'lot_no_pm',
        'lot',
        'coa',
        'qty',
        'mfg',
        'exp',
        'action',
        'quality_check',
        'transport_check',
        'sender_vehicle_plate',
        'transport_check_detail',
        'notation',
        'company_id',
        'packaging_id',
        'receive_packaging_id',
        'history_receive_packaging_id',
    ];
    public function packaging(){
        return $this->belongsTo(Packaging::class,'packaging_id');
    }

    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
    //OUT [PK]
    public function packagingInspects(){
        return $this->hasMany(PackagingInspect::class,'packaging_lot_id');
    }

    public function packagingCutReturns(){
        return $this->hasMany(PackagingCutReturn::class,'packaging_lot_id');
    }
}
