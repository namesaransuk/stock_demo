<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface MaterialInspectInterface extends BaseInterface
{
    public function getInspectDetailByMaterialLotID($id):Collection;
}

