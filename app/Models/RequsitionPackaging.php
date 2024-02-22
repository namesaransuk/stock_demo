<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequsitionPackaging extends Model
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
        'product_name',
        'production_user_id',
        'procurement_user_id',
        'stock_user_id',
        'recap',
        'ins_cut',
        'ins_return',
        'company_id',
    ];

    //IN [FK]
    public function productionUser(){
        return $this->belongsTo(User::class,'production_user_id');
    }

    public function procurementUser(){
        return $this->belongsTo(User::class,'procurement_user_id');
    }

    public function stockUser(){
        return $this->belongsTo(User::class,'stock_user_id');
    }
    //OUT [PK]
    public function packagingCutReturns(){
        return $this->hasMany(PackagingCutReturn::class,'requsition_packaging_id');
    }
}
