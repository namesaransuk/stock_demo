<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PackagingUnitInterface extends BaseInterface
{
    public function getAllPackagingUnit($param): Collection;
    public function paginate($param): Collection;

}

