<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'brand',
        'model',
        'plate',
        'record_status',
        'company_id',
    ];

    //IN [FK]
    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
    //OUT [PK]
    public function requsitionProducts(){
        return $this->hasMany(RequsitionProduct::class,'vehocle_id');
    }

}
