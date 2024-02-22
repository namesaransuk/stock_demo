<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Repositories\CompanyInterface;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        //        Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])
        $company_login = $request->company;
        $check_company = $user->userCompanies()->where('company_id', '=', $company_login)->count();
        $credentials = $request->only('email', 'password');
        //        $credentials = array_merge($credentials, ['type' => 'USER']);
        if (Auth::attempt($credentials) && $check_company > 0) {
            // Authentication passed...
            $request->session()->put('company', $company_login);
            $company_name = $this->companyRepository->find($company_login);
            $request->session()->put('company_name', $company_name->name_th);
            //            return $this->sendLoginResponse($request);
        } else {
            if ($user->isUser('qcm') || $user->isUser('qcpk') || $user->isUser('sm') || $user->isUser('spk')) {
                auth()->logout();
                session()->flash('alert_message', 'ไม่สามารถเข้าสู่ระบบได้ กรุณาตรวจสอบบริษัทที่ท่านเลือก');
                return redirect()->route('login');
            }
        }
        return $this->sendFailedLoginResponse($request);
    }

    public function showLoginForm()
    {
        $companies = $this->companyRepository->all()->where('record_status', '=', 1);
        return view('auth.login', compact('companies'));
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $companyRepository;
    public function __construct(CompanyInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->middleware('guest')->except('logout');
    }
}
