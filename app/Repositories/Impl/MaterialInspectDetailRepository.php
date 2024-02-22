<?php


namespace App\Repositories\Impl;
use App\Models\MaterialInspectDetail;
use App\Repositories\MaterialInspectDetailInterface;

class MaterialInspectDetailRepository extends BaseRepository implements MaterialInspectDetailInterface
{

    protected $model;

    public function __construct(MaterialInspectDetail $model)
    {
       parent::__construct($model);
    }







}
