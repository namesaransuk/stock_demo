<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialLot extends Model
{
    use HasFactory;
    protected $fillable = [
        'lot_no_pm',
        'lot',
        'coa',
        'weight_grams',
        'weight_kg',
        'weight_ton',
        'weight_total',
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
        'receive_material_id',
        'material_id',
        'material_unit_id',
        'receive_mat_name'
    ];

    //IN [FK]
    public function material(){
        return $this->belongsTo(Material::class,'material_id');
    }

    public function receiveMaterial(){
        return $this->belongsTo(ReceiveMaterial::class,'receive_material_id');
    }

    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }

    public function materialUnit(){
        return $this->belongsTo(MaterialUnit::class,'material_unit_id');
    }
    //OUT [PK]
    public function materialInspects(){
        return $this->hasMany(MaterialInspect::class,'material_lot_id');
    }

    public function materialCutReturns(){
        return $this->hasMany(MaterialCutReturn::class,'material_lot_id');
    }

    public function transportPic(){
        return $this->hasMany(TransportPic::class,'material_lot_id');
    }

    protected $appends = ['weight_total_show','action_text'];
    public function getWeightTotalShowAttribute()
    {
        $weight = $this->weight_total;
        $wunit = "กรัม";
        $total_weight = number_format($weight,2) ;
        if ($weight >= 1000000) {
            $total_weight = number_format($weight/1000000,2) ;
            $wunit = "ตัน";
        } else if ($weight >= 1000) {
            $total_weight = number_format($weight/1000,2);
            $wunit = "กิโลกรัม";
        }

        return $total_weight.' '.$wunit;
    }

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
