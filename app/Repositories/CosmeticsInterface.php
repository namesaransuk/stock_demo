<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface CosmeticsInterface extends BaseInterface
{
    public function getAllCosmetics($param): Collection;
    public function paginate($param): Collection;

}

