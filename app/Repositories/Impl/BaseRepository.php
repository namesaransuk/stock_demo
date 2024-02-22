<?php


namespace App\Repositories\Impl;


use App\Repositories\BaseInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository implements BaseInterface
{

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all() : Collection
    {
        return $this->model->get();
    }

    public function find($id): ?Model
    {
        return $this->model->find($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): Model
    {
        $obj = $this->model->find($id);
        $obj->update($data);
        return $obj;
    }

    public function delete($id)
    {
        return $this->model->find($id)->delete();
    }

}
