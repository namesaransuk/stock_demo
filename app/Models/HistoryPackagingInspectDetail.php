<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPackagingInspectDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'ins_times',
        'ins_qty',
        'detail',
        'history_packaging_inspect_id',
        'packaging_inspect_id',
        'audit_user_id',
    ];
}
