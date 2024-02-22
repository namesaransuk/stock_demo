<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface VehicleInterface extends BaseInterface
{
    public function count():int;
    public function paginate($param):Collection;
    public function getAllVehicles($name):Collection;

}

