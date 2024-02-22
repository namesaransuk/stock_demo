<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagingCutReturn extends Model
{
    use HasFactory;
    protected $fillable = [
        'datetime',
        'qty',
        'action',
        'create_date',
        'update_date',
        'created_by',
        'updated_by',

        'use_qty',
        'met_good',
        'met_waste',
        'met_claim',
        'met_destroy',

        'requsition_packaging_id',
        'packaging_lot_id',
        'reserve',
        'inventory_approve',
    ];

    //IN [FK]
    public function packagingLot(){
        return $this->belongsTo(PackagingLot::class,'packaging_lot_id');
    }

    public function requsitionPackaging(){
        return $this->belongsTo(RequsitionPackaging::class,'requsition_packaging_id');
    }

    //OUT [PK]

}
