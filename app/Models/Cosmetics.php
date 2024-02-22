<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cosmetics extends Model
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
