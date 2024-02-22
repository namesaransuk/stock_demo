<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseInterface
{
    public function all():Collection;
    public function find($id): ?Model;
    public function create(array $data): Model;
    public function update($id,array $data): Model;
    public function delete($id);
}

