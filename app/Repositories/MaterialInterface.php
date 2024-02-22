<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface MaterialInterface extends BaseInterface
{
    public function getAll();
    public function getAllMaterial();
    public function chartImpl();
    public function materialList();
    public function count(): int;
    public function paginate($param): Collection;

    public function countInventory($param): int;
    public function paginateInventory($param): Collection;

    public function countReceiveReport($param): int;
    public function paginateReceiveReport($param): Collection;

    public function countRequsitionReport($param): int;
    public function paginateRequsitionReport($param): Collection;

    public function getAllMaterials($param): Collection;
    public function getMaterialLotDetailByID($id): Collection;
    public function getAllWithStockRemain(): Collection;

    public function tradeNameAndRemain($trade_name): Collection;
}
