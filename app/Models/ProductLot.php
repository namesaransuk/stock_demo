<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductLot extends Model
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
    ];

    //IN [FK]


    public function receiveProduct(){
        return $this->belongsTo(ReceiveProduct::class,'receive_product_id');
    }

    public function productUnit(){
        return $this->belongsTo(ProductUnit::class,'product_unit_id');
    }

    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }

    public function unit(){
        return $this->belongsTo(Unit::class,'unit_id');
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    //OUT [PK]
    public function productCuts(){
        return $this->hasMany(ProductCut::class,'product_lot_id');
    }

    protected $appends = ['check_qty'];
    public function getCheckQtyAttribute()
    {
        $qty = $this->qty_check;
        if ($qty !== null) {
            if ($qty == 0) {
                $qty_text = "ไม่ผ่าน";
            }else if($qty == 1){
                $qty_text = "ผ่าน";
            };
        }else{
            $qty_text = "กำลังดำเนินการ";
        }
        return $qty_text;
    }
}
