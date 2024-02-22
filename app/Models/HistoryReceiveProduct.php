<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryReceiveProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_no',
        'paper_status',
        'edit_times',
        'date',
        'inspect_ready',
        'created_by',
        'updated_by',
        'production_user_id',
        'stock_user_id',
        'recap',
        'receive_product_id',
        'company_id',

    ];

    public function historyProductLots(){
        return $this->hasMany(HistoryProductLot::class,'history_receive_product_id');
    }
}
