<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryReceiveMaterial extends Model
{
    use HasFactory;
    protected $fillable = [
        'po_no',
        'po_file_name',
        'paper_no',
        'edit_times',
        'reject_status',
        'reject_detail',
        'date',
        'inspect_ready',
        'created_by',
        'updated_by',
        'receive_material_id',
        'stock_user_id',
        'audit_user_id',
        'brand_vendor_id',
        'logistic_vendor_id',
        'recap',
        'company_id',
    ];
    public function brandVendor(){
        return $this->belongsTo(Vendor::class,'brand_vendor_id');
    }

    public function logisticVendor(){
        return $this->belongsTo(Vendor::class,'logistic_vendor_id');
    }
    public function historymaterialLots(){
        return $this->hasMany(HistoryMaterialLot::class,'history_receive_material_id');
    }
}
