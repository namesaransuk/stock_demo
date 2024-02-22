<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPackagingCutReturn extends Model
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
        'requsition_packaging_id',
        'packaging_lot_id',
        'history_requsition_packaging_id',
    ];
    public function packagingLot(){
        return $this->belongsTo(PackagingLot::class,'packaging_lot_id');
    }
}
