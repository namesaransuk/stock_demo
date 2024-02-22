<?php


namespace App\Repositories\Impl;

use App\Models\InspectTemplateDetail;
use App\Repositories\InspectTemplateDetailInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InspectTemplateDetailRepository extends BaseRepository implements InspectTemplateDetailInterface
{

    protected $model;

    public function __construct(InspectTemplateDetail $model)
    {
       parent::__construct($model);
    }

    public function count($id): int
    {
        return DB::table('inspect_template_details')
        ->select(DB::raw('count(*) as inspect_template_details_count'))
        ->where('inspect_template_id','=',$id)
        ->count();
    }

    public function paginate($id,$param): Collection
    {
        return $this->model->with('inspectTopic','inspectTemplate')->orderBy($param['columnName'],$param['columnSortOrder'])
//
            ->where(function($q) use ($param) {
                // $q->where('name', 'like', '%' .$param['searchValue'] . '%');
            })
            ->select('*')
            ->where('inspect_template_id','=',$id)
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllInspectTemplateDetails($id,$name): Collection
    {
        $inspect_template_details = DB::table('inspect_template_details')
            ->select('*')
            ->where('inspect_template_id','=',$id)
            ->where('name', 'like', '%' .$name . '%')
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $inspect_template_details;
    }

    public function getAllTemplateDetails($id): Collection
    {
        return $this->model->with('inspectTopic.category','inspectTemplate')
            ->select('*')
            ->where('inspect_template_id','=',$id)
            ->get();
    }

    public function deleteOldTemplateDetailByTemplateID($id)
    {
        return DB::table('inspect_template_details')
        ->where('inspect_template_id', '=', $id)->delete();
    }
}
