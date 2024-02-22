<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface SupplyLotInterface extends BaseInterface
{

    public function getAllSupplyLot($id):Collection;
    public function getSupplyLotBySupplyId($id):Collection;
    public function updateActionByReceiveID($id);
    public function getLotRemainById($id):Collection;
    public function getData($param):Collection;
}

