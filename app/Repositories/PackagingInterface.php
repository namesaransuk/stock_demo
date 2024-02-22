<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PackagingInterface extends BaseInterface
{
    public function count():int;
    public function getAll();
    public function chartImpl();
    public function countInventory($param):int;
    public function paginateInventory($param):Collection;

    public function countReceiveReport($param):int;
    public function paginateReceiveReport($param):Collection;

    public function countRequsitionReport($param):int;
    public function paginateRequsitionReport($param):Collection;

    public function paginate($param):Collection;
    public function getAllPackages($name):Collection;
    public function getAllWithStockRemain():Collection;

}

