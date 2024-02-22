<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagingLot extends Model
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
        'transport_check_1',
        'transport_check_2',
        'transport_check_3',
        'transport_check_4',
        'transport_check_5',
        'qty_check',
        'notation',
        'company_id',
        'packaging_id',
        'receive_packaging_id',
    ];

    //IN [FK]
    public function packaging(){
        return $this->belongsTo(Packaging::class,'packaging_id');
    }

    public function receivePackaging(){
        return $this->belongsTo(ReceivePackaging::class,'receive_packaging_id');
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

    public function transportPic(){
        return $this->hasMany(TransportPic::class,'packaging_lot_id');
    }

    protected $appends = ['action_text'];

    public function getActionTextAttribute()
    {
        $action = $this->action;
        if ($action == 1) {
            $action_text = 'ยังไม่ผ่านการตรวจสอบ';
        } else if ($action == 2) {
            $action_text = 'อยู่ระหว่างการตรวจสอบ';
        }
        else if ($action == 3) {
            $action_text = 'ตรวจสอบแล้วแต่ยังไม่ได้ lot no pm';
        }
        else{
            $action_text = 'พร้อมใช้งาน';
        }

        return $action_text;
    }

}
