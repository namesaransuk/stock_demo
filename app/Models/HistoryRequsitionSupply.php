<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryRequsitionSupply extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_no',
        'edit_times',
        'date',
        'paper_status',
        'created_by',
        'updated_by',
        'stock_user_id',
        'requsition_supply_id',
        'detail',
        'recap',
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

    public function supplyCut(){
        return $this->hasMany(SupplyCut::class,'requsition_supply_id');
    }

    public function historysupplycut(){
        return $this->hasMany(HistorySupplyCut::class,'history_requsition_supply_id');
    }
}
