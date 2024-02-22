<?php


namespace App\Repositories\Impl;

use App\Models\FdaBrand;
use App\Repositories\FdaBrandInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class FdaBrandRepository extends BaseRepository implements FdaBrandInterface
{

    protected $model;

    public function __construct(FdaBrand $model)
    {
       parent::__construct($model);
    }

}
