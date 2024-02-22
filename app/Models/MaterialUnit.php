<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialUnit extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'multiply',
        'unit',
        'record_status',
    ];

    //IN [FK]

    //OUT [PK]
    public function materialLots(){
        return $this->hasMany(MaterialLot::class,'material_unit_id');
    }
}
