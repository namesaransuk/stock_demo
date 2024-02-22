<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryProductInspect extends Model
{
    use HasFactory;
    protected $fillable = [
        'ins_template_name',
        'ins_topic',
        'ins_method',
        'ins_type',
        'sequence',
        'product_inspect_id',
        'product_lot_id',
        'inspect_template_id',
    ];
}
