<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInspectDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'ins_times',
        'ins_qty',
        'detail',
        'product_lot_id',
        'product_inspect_id',
        'audit_user_id',
    ];

    //IN [FK]
    public function productInspect(){
        return $this->belongsTo(ProductInspect::class,'product_inspect_id');
    }
}
