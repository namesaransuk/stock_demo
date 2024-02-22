<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryRequsitionPackaging extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_no',
        'edit_times',
        'date',
        'history_flag',
        'paper_status',
        'created_by',
        'updated_by',
        'product_name',
        'requsition_packaging_id',
        'production_user_id',
        'procurement_user_id',
        'stock_user_id',
        'recap',
        'company_id',
    ];
    public function historypackagingcutreturn(){
        return $this->hasMany(HistoryPackagingCutReturn::class,'history_requsition_packaging_id');
    }
}
