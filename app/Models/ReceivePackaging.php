<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivePackaging extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_no',
        'po_no',
        'po_file_name',
        'coa',
        'paper_status',
        'reject_status',
        'reject_detail',
        'edit_times',
        'date',
        'inspect_ready',
        'created_by',
        'updated_by',
        'stock_user_id',
        'audit_user_id',
        'brand_vendor_id',
        'logistic_vendor_id',
        'recap',
        'company_id',
    ];

    //IN [FK]
    public function stockUser(){
        return $this->belongsTo(User::class,'stock_user_id');
    }

    public function auditUser(){
        return $this->belongsTo(User::class,'updated_by');
    }

    public function logisticVendor(){
        return $this->belongsTo(Vendor::class,'logistic_vendor_id');
    }

    public function brandVendor(){
        return $this->belongsTo(Vendor::class,'brand_vendor_id');
    }
    //OUT [PK]
    public function packagingLots(){
        return $this->hasMany(PackagingLot::class,'receive_packaging_id');
    }



}
