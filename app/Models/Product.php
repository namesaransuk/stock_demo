<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'itemcode',
        'created_by',
        'updated_by',
        'record_status',
        'brand_id',
        'category_id',
        'company_id',
    ];
    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function productLot(){
        return $this->hasMany(ProductLot::class,'product_id');
    }
}
