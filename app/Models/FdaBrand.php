<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FdaBrand extends Model
{
    use HasFactory;
    protected $fillable = [
        'brand',
        'abbreviation',
        'record_status'
    ];
}
