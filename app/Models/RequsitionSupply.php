<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequsitionSupply extends Model
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
        'recap',
        'detail',
        'company_id',
    ];

    public function stockUser(){
        return $this->belongsTo(User::class,'stock_user_id');
    }

    public function supplyCut(){
        return $this->hasMany(SupplyCut::class,'requsition_supply_id');
    }

}
