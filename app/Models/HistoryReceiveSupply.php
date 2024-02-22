<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryReceiveSupply extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_no',
        'paper_status',
        'edit_times',
        'date',
        'reject_status',
        'reject_detail',
        'created_by',
        'updated_by',
        'stock_user_id',
        'recap',
        'receive_supply_id',
        'brand_vendor_id',
        'company_id',
    ];

    public function stockUser(){
        return $this->belongsTo(User::class,'stock_user_id');
    }

    public function createUser(){
        return $this->belongsTo(User::class,'created_by');
    }

    public function updateUser(){
        return $this->belongsTo(User::class,'updated_by');
    }



    public function brandVendor(){
        return $this->belongsTo(Vendor::class,'brand_vendor_id');
    }

    public function historySupplyLots(){
        return $this->hasMany(HistorySupplyLot::class,'history_receive_supply_id');
    }
}
