<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface InspectTemplateDetailInterface extends BaseInterface
{
    public function count($id):int;
    public function paginate($id,$param):Collection;
    public function getAllInspectTemplateDetails($id,$name):Collection;
    public function getAllTemplateDetails($id):Collection;
    public function deleteOldTemplateDetailByTemplateID($id);

}

