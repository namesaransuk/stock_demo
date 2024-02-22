<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyInterface;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    private $companyRepository;
    public function __construct(CompanyInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }
    public function list()
    {
        $companies = $this->companyRepository->all();
        return view('admin.vehicle',compact('companies'));
    }
}
