<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectTopic extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'method',
        'category_id',
        'record_status',
        'create_date',
        'update_date',
    ];

    //IN [FK]
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    //OUT [PK]
    public function packagingInspects(){
        return $this->hasMany(PackagingInspect::class,'inspect_topic_id');
    }
    public function materialInspects(){
        return $this->hasMany(MaterialInspect::class,'inspect_topic_id');
    }
    public function inspectTemplates(){
        return $this->hasMany(InspectTemplate::class,'inspect_topic_id');
    }

}
