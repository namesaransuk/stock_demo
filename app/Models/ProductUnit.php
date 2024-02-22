<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnit extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'multiply',
        'record_status',
    ];

    //IN [FK]

    //OUT [PK]
    public function productLots(){
        return $this->hasMany(ProductLot::class,'product_unit_id');
    }
}
