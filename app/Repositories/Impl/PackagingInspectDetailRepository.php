<?php


namespace App\Repositories\Impl;
use App\Models\PackagingInspectDetail;
use App\Repositories\PackagingInspectDetailInterface;
use Illuminate\Support\Collection;

class PackagingInspectDetailRepository extends BaseRepository implements PackagingInspectDetailInterface
{

    protected $model;

    public function __construct(PackagingInspectDetail $model)
    {
       parent::__construct($model);
    }










}
