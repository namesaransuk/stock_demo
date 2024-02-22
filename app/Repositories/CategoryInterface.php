<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface CategoryInterface extends BaseInterface
{
    public function count():int;
    public function paginate($param):Collection;
    public function getAllCategories($name):Collection;
    public function getMatCategories():Collection;

}

