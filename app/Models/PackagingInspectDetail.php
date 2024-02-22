<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagingInspectDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'ins_times',
        'ins_qty',
        'detail',
        'packaging_lot_id',
        'packaging_inspect_id',
        'audit_user_id',
    ];
    //IN [FK]
    public function packagingInspect(){
        return $this->belongsTo(PackagingInspect::class,'packaging_inspect_id');
    }
}
