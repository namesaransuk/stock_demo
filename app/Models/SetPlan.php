<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetPlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_add',
        'event',
        'start',
        'end',
        'color',
        'remark',
    ];

}
