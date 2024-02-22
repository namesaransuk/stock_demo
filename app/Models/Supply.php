<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'record_status',
        'company_id',
    ];
    //IN [FK]
    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
    //OUT [PK]
    public function supplyLots(){
        return $this->hasMany(ProductLot::class,'unit_id');
    }
}
