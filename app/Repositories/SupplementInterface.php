<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface SupplementInterface extends BaseInterface
{
    public function getAllSupplement($param): Collection;
    public function paginate($param): Collection;
}

