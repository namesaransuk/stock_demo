<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface UserInterface extends BaseInterface
{
    public function count():int;
    public function paginate($param):Collection;
    public function getAllUsers($name):Collection;
    public function getUserInfo($id);

}

