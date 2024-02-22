<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prefix extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'record_status',
    ];

    //IN [FK]

    //OUT [PK]
    public function employees(){
        return $this->hasMany(Employee::class,'prefix_id');
    }

}
