<?php


namespace App\Repositories\Impl;

use App\Models\InspectTopic;
use App\Repositories\InspectTopicInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class InspectTopicRepository extends BaseRepository implements InspectTopicInterface
{

    protected $model;

    public function __construct(InspectTopic $model)
    {
       parent::__construct($model);
    }

    public function count(): int
    {
        return DB::table('inspect_topics')
        ->select(DB::raw('count(*) as inspect_topic_count'))
        ->where('record_status','=',1)
        ->count();
    }

    public function paginate($param): Collection
    {
        return $this->model->with('category')->orderBy($param['columnName'],$param['columnSortOrder'])
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
    public function getAllInspectTopics($name): Collection
    {
        $inspect_topic = DB::table('inspect_topics')
            ->select('*')
            ->where('record_status','=',1)
            ->where('name', 'like', '%' .$name . '%')
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $inspect_topic;
    }

    public function getInspectTopicByCategoryID($id)
    {

        $inspect_topic = DB::table('inspect_topics')
            ->select('*')
            ->where('record_status','=',1)
            ->where('category_id','=',$id)
            ->get();
        return $inspect_topic;
    }

}
