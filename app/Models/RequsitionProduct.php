<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequsitionProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_no',
        'paper_status',
        'edit_times',
        'date',
        'ins_cut',
        'ins_return',
        'created_by',
        'updated_by',
        'transport_user_id',
        'audit_user_id',
        'qc_user_id',
        'stock_user_id',
        'vehicle_id',
        'recap',

        'receive_name',
        'receive_vehicle',
        'receive_house_no',
        'receive_tumbol',
        'receive_aumphur',
        'receive_province',
        'receive_postcode',
        'receive_full_addr',
        'receive_tel',
        'transport_type',
        'company_id',
    ];

    //IN [FK]
    public function transportUser(){
        return $this->belongsTo(User::class,'transport_user_id');
    }

    public function auditUser(){
        return $this->belongsTo(User::class,'audit_user_id');
    }

    public function qcUser(){
        return $this->belongsTo(User::class,'qc_user_id');
    }

    public function stockUser(){
        return $this->belongsTo(User::class,'stock_user_id');
    }

    public function vehicle(){
        return $this->belongsTo(Vehicle::class,'vehicle_id');
    }
    //OUT [PK]
    public function productCuts(){
        return $this->hasMany(ProductCut::class,'requsition_product_id');
    }
}
