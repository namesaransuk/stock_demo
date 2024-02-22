<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'product_import_flag',
        'record_status',
    ];

    //IN [FK]

    // OUT [PK]
    public function inspectTopics(){
        return $this->hasMany(InspectTopic::class,'category_id');
    }
    public function productLots(){
        return $this->hasMany(ProductLot::class,'category_id');
    }
    public function materials(){
        return $this->hasMany(Material::class,'category_id');
    }

}
