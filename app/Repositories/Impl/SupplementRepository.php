<?php


namespace App\Repositories\Impl;

use App\Models\Supplement;
use App\Repositories\SupplementInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SupplementRepository extends BaseRepository implements SupplementInterface
{
    protected $model;

    public function __construct(Supplement $model)
    {
       parent::__construct($model);
    }

    public function paginate($param): Collection
    {
        return $this->model->orderBy($param['columnName'], $param['columnSortOrder'])
            ->where('record_status','=',1)
            ->where(function ($q) use ($param) {
                if (isset($param['searchValue'])) {
                    $q->where('id', "like", '%' . $param['searchValue'] . '%');
                    $q->orwhere('name', "like", '%' . $param['searchValue'] . '%');
                    $q->orwhere('abbreviation', "like", '%' . $param['searchValue'] . '%');
                    $q->orwhere('definition', "like", '%' . $param['searchValue'] . '%');
                    $q->orwhere('name_en', "like", '%' . $param['searchValue'] . '%');
                }
            })
            ->select('*')
            ->skip($param['start'])
            ->take($param['rowperpage'])
            ->get();
    }
    public function getAllSupplement($param): Collection
    {
        return $this->model
            ->select('*')
            ->where('record_status','=',1)
            ->where(function ($q) use ($param) {
                if (isset($param['searchValue'])) {
                    $q->where('id', "like", '%' . $param['searchValue'] . '%');
                    $q->orwhere('name', "like", '%' . $param['searchValue'] . '%');
                    $q->orwhere('abbreviation', "like", '%' . $param['searchValue'] . '%');
                    $q->orwhere('definition', "like", '%' . $param['searchValue'] . '%');
                    $q->orwhere('name_en', "like", '%' . $param['searchValue'] . '%');
                }
            })
            ->get();
    }
}
