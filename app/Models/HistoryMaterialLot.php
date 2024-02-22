<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryMaterialLot extends Model
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
        'notation',
        'create_date',
        'update_date',
        'company_id',
        'material_id',
        'receive_mat_name',
        'receive_material_id',
        'history_receive_material_id',
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
        //OUT [PK]
        public function materialInspects(){
            return $this->hasMany(MaterialInspect::class,'material_lot_id');
        }

        public function materialCutReturns(){
            return $this->hasMany(MaterialCutReturn::class,'material_lot_id');
        }
}
