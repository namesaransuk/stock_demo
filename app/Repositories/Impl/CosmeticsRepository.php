<?php


namespace App\Repositories\Impl;

use App\Models\Cosmetics;
use App\Repositories\CosmeticsInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CosmeticsRepository extends BaseRepository implements CosmeticsInterface
{

    protected $model;

    public function __construct(Cosmetics $model)
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
    public function getAllCosmetics($param): Collection
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
