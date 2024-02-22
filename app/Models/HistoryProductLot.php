<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryProductLot extends Model
{
    use HasFactory;
    protected $fillable = [
        'lot',
        'qty',
        'mfg',
        'exp',
        'action',
        'quality_check',
        'notation',
        'qty_check',
        'company_id',
        'product_id',
        'receive_product_id',
        'unit_id',
        'product_unit_id',
        'history_receive_product_id',
    ];
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function unit(){
        return $this->belongsTo(Unit::class,'unit_id');
    }

    public function productUnit(){
        return $this->belongsTo(ProductUnit::class,'product_unit_id');
    }

    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }


}
