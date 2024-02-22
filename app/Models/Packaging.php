<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'itemcode',
        'is_active',
        'type',
        'weight_per_qty',
        'volumetric_unit',
        'record_status',
        'brand_id',
        'company_id',
        'packaging_type_id',
        'create_date',
        'update_date',
    ];

    //IN [FK]
    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
    //OUT [PK]
    public function packagingLots(){
        return $this->hasMany(PackagingLot::class,'packaging_id');
    }
}
