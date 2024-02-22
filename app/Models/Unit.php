<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'name_en',
        'abbreviation',
        'definition',
        // 'abbreviation_th',
        // 'abbreviation_en',
        'record_status',
    ];
    //IN [FK]

    //OUT [PK]
    public function productLots(){
        return $this->hasMany(ProductLot::class,'unit_id');
    }
}
