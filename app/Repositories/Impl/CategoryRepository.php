<?php


namespace App\Repositories\Impl;

use App\Models\Category;
use App\Repositories\CategoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository implements CategoryInterface
{

    protected $model;

    public function __construct(Category $model)
    {
       parent::__construct($model);
    }

    public function count(): int
    {
        return DB::table('categories')
        ->select(DB::raw('count(*) as categories_count'))
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
    public function getAllCategories($name): Collection
    {
        $inspect_topic_types = DB::table('categories')
            ->select('*')
            ->where('record_status','=',1)
            ->where('name', 'like', '%' .$name . '%')
            // ->where([
            //     ['display', '=', 1]
            // ])
            ->get();
        return $inspect_topic_types;
    }

    public function getMatCategories(): Collection
    {
        $value = DB::table('categories')
            ->select('*')
            ->where('record_status','=',1)
            ->where('product_import_flag','=',1)
            ->get();
        return $value;
    }

}
