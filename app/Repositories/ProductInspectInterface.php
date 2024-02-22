<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ProductInspectInterface extends BaseInterface
{
    public function getInspectDetailByProductLotID($id):Collection;
}

