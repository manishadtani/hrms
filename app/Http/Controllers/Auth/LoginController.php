<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Log successful login
     */
    protected function authenticated(Request $request, $user)
    {
        activity('auth')
            ->causedBy($user)
            ->withProperties(['ip' => $request->ip()])
            ->log('User logged in');
    }

    /**
     * Log logout
     */
    public function logout(Request $request)
    {
        activity('auth')
            ->causedBy(auth()->user())
            ->withProperties(['ip' => $request->ip()])
            ->log('User logged out');

        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
