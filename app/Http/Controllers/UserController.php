<?php

namespace App\Http\Controllers;

use App\Repositories\EmployeeInterface;
use App\Repositories\RoleInterface;
use App\Repositories\UserInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userRepository;
    private $roleRepository;
    private $employeeRepository;
    public function __construct(UserInterface $userRepository, EmployeeInterface $employeeRepository, RoleInterface $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->employeeRepository = $employeeRepository;
        $this->roleRepository = $roleRepository;
    }

    public function list()
    {
        $employees = $this->employeeRepository->getAllEmployees('');
        $roles = $this->roleRepository->getAllRoles('');
        // dd($roles);
        return view('admin.user',compact('employees','roles'));
    }

}
