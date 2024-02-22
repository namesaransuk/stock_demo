<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryProductCut extends Model
{
    use HasFactory;
    protected $fillable = [
        'datetime',
        'qty',
        'product_lot_id',
        'requsition_product_id',
        'history_requsition_product_id',
        'created_by',
        'updated_by',
    ];

    public function productLot(){
        return $this->belongsTo(ProductLot::class,'product_lot_id');
    }
}
