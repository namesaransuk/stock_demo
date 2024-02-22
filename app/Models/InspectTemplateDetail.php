<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectTemplateDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'inspect_template_id',
        'inspect_topic_id',
        'create_date',
        'update_date',
    ];

    //IN [FK]
    public function inspectTopic(){
        return $this->belongsTo(InspectTopic::class,'inspect_topic_id');
    }
    public function inspectTemplate(){
        return $this->belongsTo(InspectTemplate::class,'inspect_template_id');
    }
}
