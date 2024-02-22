<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ProductInterface extends BaseInterface
{
    public function count():int;
    public function getAll();
    public function paginate($param):Collection;
    public function getAllProducts($name):Collection;
    public function getProductLotDetailByID($id):Collection;
    public function getAllWithStockRemain():Collection;

    public function countReceiveReport($param):int;
    public function paginateReceiveReport($param):Collection;

    public function countRequsitionReport($param):int;
    public function paginateRequsitionReport($param):Collection;

    public function chartImpl();
    public function countInventory($param):int;
    public function paginateInventory($param):Collection;
}

