<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialCutReturn extends Model
{
    use HasFactory;
    protected $fillable = [
        'datetime',
        'weight',
        'action',
        'material_lot_id',
        'created_by',
        'updated_by',
        'requsition_material_id',
        'reserve',
        'inventory_approve',
        'create_date',
        'update_date',
    ];

    //IN [FK]
    public function materialLot(){
        return $this->belongsTo(MaterialLot::class,'material_lot_id');
    }

    public function requsitionMaterial(){
        return $this->belongsTo(RequsitionMaterial::class,'requsition_material_id');
    }

    public function createBy(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function updateBy(){
        return $this->belongsTo(User::class,'updated_by');
    }
    //OUT [PK]

    protected $appends = ['weight_total_show'];
    public function getWeightTotalShowAttribute()
    {
        $weight = $this->weight;
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

}
