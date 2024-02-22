<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiveProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'paper_no',
        'paper_status',
        'edit_times',
        'date',
        'inspect_ready',
        'created_by',
        'updated_by',
        'production_user_id',
        'stock_user_id',
        'recap',
        'receive_product_id',
        'company_id',
    ];

    //IN [FK]
    public function productionUser(){
        return $this->belongsTo(User::class,'production_user_id');
    }

    public function stockUser(){
        return $this->belongsTo(User::class,'stock_user_id');
    }

    public function updateUser(){
        return $this->belongsTo(User::class,'updated_by');
    }
    //OUT [PK]
    public function productLots(){
        return $this->hasMany(ProductLot::class,'receive_product_id');
    }
}
