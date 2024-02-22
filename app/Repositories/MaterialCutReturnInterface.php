<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface MaterialCutReturnInterface extends BaseInterface
{
    public function getAllMaterialRequsitionLot($id):Collection;
    public function getData($param):Collection;
    public function getCutReturnById($material_lot_id): Collection;
}

