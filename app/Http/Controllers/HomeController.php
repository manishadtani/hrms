<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     * 'auth' middleware means: user MUST be logged in to access this.
     *
     * MERN equivalent:
     * router.get('/home', authMiddleware, homeHandler)
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Redirect user to their role-based dashboard after login.
     *
     * MERN equivalent:
     * if (user.role === 'admin') return res.redirect('/admin/dashboard');
     * else if (user.role === 'manager') return res.redirect('/manager/dashboard');
     * else return res.redirect('/employee/dashboard');
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('manager')) {
            return redirect()->route('manager.dashboard');
        } else {
            return redirect()->route('employee.dashboard');
        }
    }
}
