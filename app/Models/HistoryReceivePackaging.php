<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryReceivePackaging extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_no',
        'po_no',
        'po_file_name',
        'edit_times',
        'date',
        'reject_status',
        'reject_detail',
        'inspect_ready',
        'created_by',
        'updated_by',
        'receive_packaging_id',
        'stock_user_id',
        'audit_user_id',
        'brand_vendor_id',
        'logistic_vendor_id',
        'company_id',
        'recap',
    ];
    public function stockUser(){
        return $this->belongsTo(User::class,'stock_user_id');
    }

    public function auditUser(){
        return $this->belongsTo(User::class,'audit_user_id');
    }

    public function logisticVendor(){
        return $this->belongsTo(Vendor::class,'logistic_vendor_id');
    }

    public function brandVendor(){
        return $this->belongsTo(Vendor::class,'brand_vendor_id');
    }
    //OUT [PK]
    public function historypackagingLots(){
        return $this->hasMany(HistoryPackagingLot::class,'history_receive_packaging_id');
    }
}
