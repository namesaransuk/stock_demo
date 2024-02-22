<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialInspectDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'ins_times',
        'ins_qty',
        'detail',
        'material_inspect_id',
        'material_lot_id',
        'audit_user_id',
    ];

    //IN [FK]
    public function materialInspect(){
        return $this->belongsTo(MaterialInspect::class,'material_inspect_id');
    }

    public function auditUser(){
        return $this->belongsTo(User::class,'audit_user_id');
    }

    //OUT [PK]

}
