<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    // protected $redirectTo = 'backend/dashboard';

    protected $redirectTo = RouteServiceProvider::HOME;

    protected function redirectTo()
    {
        return 'backend/dashboard';

    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        // Check if the given login credentials contain a valid email address
        $isEmail = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL);

        // Modify the login attempt based on the provided credentials
        if ($isEmail) {
            $attemptResult = $this->guard()->attempt(
                ['email' => $credentials['email'], 'password' => $credentials['password']],
                $request->filled('remember')
            );
        } else {
            $attemptResult = $this->guard()->attempt(
                ['name' => $credentials['email'], 'password' => $credentials['password']],
                $request->filled('remember')
            );
        }
        return $attemptResult;
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/login');
    }


}
