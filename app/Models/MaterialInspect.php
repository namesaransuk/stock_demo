<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialInspect extends Model
{
    use HasFactory;
    protected $fillable = [
        'ins_template_name',
        'ins_topic',
        'ins_method',
        'sequence',
        'ins_type',
        'inspect_template_id',
        'material_lot_id',
    ];

    //IN [FK]
    public function materialLot(){
        return $this->belongsTo(MaterialLot::class,'material_lot_id');
    }

    //OUT [PK]
    public function materialInspectDetails(){
        return $this->hasMany(MaterialInspectDetail::class,'material_inspect_id');
    }

}
