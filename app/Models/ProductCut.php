<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCut extends Model
{
    use HasFactory;
    protected $fillable = [
        'datetime',
        'action',
        'qty',
        'reserve',
        'inventory_approve',
        'created_by',
        'updated_by',
        'product_lot_id',
        'requsition_product_id',

    ];

    //IN [FK]
    public function productLot(){
        return $this->belongsTo(ProductLot::class,'product_lot_id');
    }

    public function requsitionProduct(){
        return $this->belongsTo(RequsitionProduct::class,'requsition_product_id');
    }
    //OUT [PK]



}
