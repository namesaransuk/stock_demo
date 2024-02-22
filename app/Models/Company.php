<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_th',
        'name_en',
        'email',
        'address_th',
        'address_en',
        'website',
        'contact_number',
        'logo',
        'record_status',
        'create_date',
        'update_date',
    ];

    // IN [FK]

    // OUT [PK]
    public function userCompanies(){
        return $this->hasMany(UserCompany::class,'company_id');
    }

    public function vehicles(){
        return $this->hasMany(Vehicle::class,'company_id');
    }

    public function materialLot(){
        return $this->hasMany(MaterialLot::class,'company_id');
    }

    public function packagingLot(){
        return $this->hasMany(PackagingLot::class,'company_id');
    }

    public function productLot(){
        return $this->hasMany(ProductLot::class,'company_id');
    }


}
