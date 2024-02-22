<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagingInspect extends Model
{
    use HasFactory;
    protected $fillable = [
        'ins_template_name',
        'ins_topic',
        'ins_method',
        'sequence',
        'ins_type',
        'inspect_template_id',
        'packaging_lot_id',
    ];


    //IN [FK]
    public function packagingLot(){
        return $this->belongsTo(PackagingLot::class,'packaging_lot_id');
    }

    public function auditUser(){
        return $this->belongsTo(User::class,'audit_user_id');
    }

    //OUT [PK]
    public function packagingInspectDetails(){
        return $this->hasMany(PackagingInspectDetail::class,'packaging_inspect_id');
    }
}
