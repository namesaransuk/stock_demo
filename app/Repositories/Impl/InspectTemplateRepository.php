<?php


namespace App\Repositories\Impl;

use App\Models\InspectTemplate;
use App\Repositories\InspectTemplateInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InspectTemplateRepository extends BaseRepository implements InspectTemplateInterface
{

    protected $model;

    public function __construct(InspectTemplate $model)
    {
       parent::__construct($model);
    }

    public function count(): int
    {
        return DB::table('inspect_templates')
        ->select(DB::raw('count(*) as inspect_templates_count'))
        ->where('record_status','=',1)
        ->count();
    }

    public function paginate($param): Collection
    {
        return $this->model->orderBy($param['columnName'],$param['columnSortOrder'])
//
            ->where('record_status','=',1)
            ->where(function($q) use ($param) {
                $q->where('name', 'like', '%' .$param['searchValue'] . '%');
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllInspectTemplates($name): Collection
    {
        $inspect_templates = DB::table('inspect_templates')
            ->select('*')
            ->where('record_status','=',1)
            ->where('name', 'like', '%' .$name . '%')
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $inspect_templates;
    }

    public function getTemplateByID($id): Collection
    {
        $id_result = DB::table('inspect_template_details')
            ->select('*')
            ->where('inspect_template_id','=',$id)
            ->leftJoin('inspect_topics', 'inspect_topics.id', '=', 'inspect_template_details.inspect_topic_id')
            ->get();
        return $id_result;
    }

}
