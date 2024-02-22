<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface SupplyInterface extends BaseInterface
{
    public function getAll();
    public function count(): int;
    public function dataChart();
    public function paginate($param): Collection;
    public function getAllSupplies($name): Collection;
    public function getAllWithStockRemain(): Collection;

    public function countReceiveReport($param): int;
    public function paginateReceiveReport($param): Collection;

    public function countRequsitionReport($param): int;
    public function paginateRequsitionReport($param): Collection;

    public function chartImpl();
    public function countInventory($param): int;
    public function paginateInventory($param): Collection;
}
