<?php


namespace App\Repositories\Impl;
use App\Models\ProductInspectDetail;
use App\Repositories\ProductInspectDetailInterface;

class ProductInspectDetailRepository extends BaseRepository implements ProductInspectDetailInterface
{

    protected $model;

    public function __construct(ProductInspectDetail $model)
    {
       parent::__construct($model);
    }







}
