<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInspect extends Model
{
    use HasFactory;
    protected $fillable = [
        'ins_template_name',
        'ins_topic',
        'ins_method',
        'ins_type',
        'sequence',
        'inspect_template_id',
        'product_lot_id',
    ];

    //IN [FK]
    public function productLot(){
        return $this->belongsTo(ProductLot::class,'product_lot_id');
    }

    public function inspectTemplate(){
        return $this->belongsTo(InspectTemplate::class,'inspect_template_id');
    }

    //OUT [PK]
    public function productInspectDetails(){
        return $this->hasMany(ProductInspectDetail::class,'product_inspect_id');
    }
}
