<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryRequsitionMaterial extends Model
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
        'requsition_material_id',
        'production_user_id',
        'procurement_user_id',
        'stock_user_id',
        'recap',
        'company_id',
    ];
    public function historymaterialcutreturn(){
        return $this->hasMany(HistoryMaterialCutReturn::class,'history_requsition_material_id');
    }
}
