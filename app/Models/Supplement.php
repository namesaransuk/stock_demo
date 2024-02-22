<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'abbreviation',
        'definition',
        'name_en',
        'record_status'
    ];
}
