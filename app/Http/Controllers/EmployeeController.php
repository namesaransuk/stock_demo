<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyInterface;
use App\Repositories\PrefixInterface;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private $prefixRepository;
    private $companyRepository;
    public function __construct(PrefixInterface $prefixRepository, CompanyInterface $companyRepository)
    {
        $this->prefixRepository = $prefixRepository;
        $this->companyRepository = $companyRepository;
    }

    public function list()
    {
        $prefixes = $this->prefixRepository->getAllPrefixes('');
        $companies = $this->companyRepository->getAllCompany('');
        return view('admin.employee',compact('prefixes', 'companies'));
    }
}
