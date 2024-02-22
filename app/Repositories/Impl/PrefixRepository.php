<?php


namespace App\Repositories\Impl;

use App\Models\Prefix;
use App\Repositories\PrefixInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PrefixRepository extends BaseRepository implements PrefixInterface
{

    protected $model;

    public function __construct(Prefix $model)
    {
       parent::__construct($model);
    }

    public function count(): int
    {
        return DB::table('prefixes')
        ->select(DB::raw('count(*) as prefixes_count'))
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
    public function getAllPrefixes($name): Collection
    {
        $prefixes = DB::table('prefixes')
            ->select('*')
            ->where('record_status','=',1)
            ->where('name', 'like', '%' .$name . '%')
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $prefixes;
    }

}
