<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RequsitionMaterialInterface extends BaseInterface
{
    public function count($param, $id, $ins_cut, $ins_return): int;
    public function paginate($param, $id, $ins_cut, $ins_return): Collection;
    public function getAllRequsitionMaterial($param, $name, $id, $ins_cut, $ins_return): Collection;
}
