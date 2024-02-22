<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiveMaterial extends Model
{
    use HasFactory;
    protected $fillable = [
        'po_no',
        'po_file_name',
        'paper_no',
        'paper_status',
        'bill_no',
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

    public function brandVendor(){
        return $this->belongsTo(Vendor::class,'brand_vendor_id');
    }

    public function logisticVendor(){
        return $this->belongsTo(Vendor::class,'logistic_vendor_id');
    }
    //OUT [PK]
    public function materialLots(){
        return $this->hasMany(MaterialLot::class,'receive_material_id');
    }





}
