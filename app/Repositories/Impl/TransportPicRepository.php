<?php


namespace App\Repositories\Impl;


use App\Models\TransportPic;
use App\Repositories\TransportPicInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransportPicRepository extends BaseRepository implements TransportPicInterface
{

    protected $model;

    public function __construct(TransportPic $model)
    {
        parent::__construct($model);
    }

    public function getTransportId($id)
    {
        $vendors = $this->model
            ->select('*')
            ->where('material_lot_id', '=', $id)
            ->first();
        return $vendors;
    }
}
