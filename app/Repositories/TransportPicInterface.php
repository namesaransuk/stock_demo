<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface TransportPicInterface extends BaseInterface
{
    public function getTransportId($id);
}
