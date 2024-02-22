<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'brand',
        'abbreviation',
        'address',
        'contact_number',
        'contact_name',
        'type',
        'record_status',
    ];

    //IN [FK]

    //OUT [PK]
    public function receivePackagingBrandVendors(){
        return $this->hasMany(ReceivePackaging::class,'brand_vendor_id');
    }

    public function receivePackagingLogisticVendors(){
        return $this->hasMany(ReceivePackaging::class,'logistic_vendor_id');
    }

    public function receiveMaterialLogisticVendors(){
        return $this->hasMany(ReceivePackaging::class,'logistic_vendor_id');
    }
}
