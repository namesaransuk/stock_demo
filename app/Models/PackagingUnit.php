<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagingUnit extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'name_en',
        'abbreviation',
        'definition',
        'record_status'
    ];
}
