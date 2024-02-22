<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryRequsitionProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_no',
        'edit_times',
        'date',
        'paper_status',
        'history_flag',
        'created_by',
        'updated_by',
        'requsition_product_id',
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

    public function historyproductcut(){
        return $this->hasMany(HistoryProductCut::class,'history_requsition_product_id');
    }
    public function stockUser(){
        return $this->belongsTo(User::class,'stock_user_id');
    }
    public function createUser(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function updateUser(){
        return $this->belongsTo(User::class,'updated_by');
    }
}
