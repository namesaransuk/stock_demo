<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'trade_name',
        'itemcode',
        'is_active',
        'record_status',
        'category_id',
        'sub_category_id',
        'company_id',
        'supplier_id',
        'create_date',
        'update_date',
    ];

    //IN [FK]
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function brandVendor(){
        return $this->belongsTo(Vendor::class,'supplier_id');
    }
    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }
    //OUT [PK]
    public function materialLots(){
        return $this->hasMany(MaterialLot::class,'material_id');
    }


}
