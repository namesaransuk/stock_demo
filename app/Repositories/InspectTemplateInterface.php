<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface InspectTemplateInterface extends BaseInterface
{
    public function count():int;
    public function paginate($param):Collection;
    public function getAllInspectTemplates($name):Collection;

    public function getTemplateByID($id):Collection;

}

