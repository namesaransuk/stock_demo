<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectTemplate extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category_id',
        'inspect_topic_id',
        'record_status',
        'create_date',
        'update_date',
    ];

    //IN [FK]
    public function inspectTopic(){
        return $this->belongsTo(InspectTopic::class,'inspect_topic_id');
    }

    //OUT [PK]


}
