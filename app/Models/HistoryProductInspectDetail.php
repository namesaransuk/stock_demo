<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryProductInspectDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'ins_times',
        'ins_qty',
        'detail',
        'history_product_inspect_id',
        'product_lot_id',
        'product_inspect_id',
        'audit_user_id',
        'product_lot_id',
    ];
}
