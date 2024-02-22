<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'emp_no',
        'fname',
        'lname',
        'tel',
        'citizen_no',
        'record_status',
        'create_date',
        'update_date',
        'prefix_id',
        'company_id'
    ];

    //IN [FK]
    public function prefix(){
        return $this->belongsTo(Prefix::class,'prefix_id');
    }

    public function company(){
        return $this->belongsTo(Company::class,'company_id');
    }

    // OUT [PK]

    public function users(){
        return $this->hasMany(User::class,'emp_id');
    }




}
