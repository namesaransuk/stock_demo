<?php


namespace App\Repositories\Impl;

use App\Models\Company;
use App\Models\UserCompany;
use App\Repositories\CompanyInterface;
use App\Repositories\UserCompanyInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserCompanyRepository extends BaseRepository implements UserCompanyInterface
{

    protected $model;

    public function __construct(UserCompany $model)
    {
       parent::__construct($model);
    }


    public function getAllCompanyByUserID($id): Collection
    {
        $companies = $this->model->with('company')
            ->where('user_id','=',$id)
            ->get();
        return $companies;
    }

}
