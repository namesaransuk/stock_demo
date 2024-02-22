<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface MaterialUnitInterface extends BaseInterface
{
    public function count():int;
    public function paginate($param):Collection;
    public function getAllmaterialUnits($name):Collection;

}

