<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface MaterialLotInterface extends BaseInterface
{
    public function sumRemain($id);
    public function count($id):int;
    public function paginate($id,$param):Collection;
    public function getAllMaterialLot($id): Collection;
    public function getMaterialLotByMaterialId($id):Collection;
    public function getLotRemainById($id):Collection;
    public function getData($param):Collection;
}

