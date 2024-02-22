<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiveSupply extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_no',
        'paper_status',
        'edit_times',
        'reject_status',
        'reject_detail',
        'date',
        'created_by',
        'updated_by',
        'stock_user_id',
        'recap',
        'brand_vendor_id',
        'company_id',
    ];

    public function stockUser(){
        return $this->belongsTo(User::class,'stock_user_id');
    }

    public function auditUser(){
        return $this->belongsTo(User::class,'updated_by');
    }

    public function brandVendor(){
        return $this->belongsTo(Vendor::class,'brand_vendor_id');
    }

    public function supplyLots(){
        return $this->hasMany(SupplyLot::class,'receive_supply_id');
    }
}
