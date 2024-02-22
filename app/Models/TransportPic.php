<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportPic extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'created_by',
        'material_lot_id',
        'packaging_lot_id',
    ];

    public function created_by(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function receiveMaterial(){
        return $this->belongsTo(ReceiveMaterial::class,'material_lot_id');
    }

    public function receivePackaging(){
        return $this->belongsTo(ReceivePackaging::class,'packaging_lot_id');
    }
}
