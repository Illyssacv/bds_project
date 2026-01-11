<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role'     => 'user',
            'status'   => 1,
        ]);

        Auth::login($user);


        return view('/');
    }

    /**
     * LOGIN
     */
    public function login(LoginRequest $request)
    {

        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();
            if (Auth::user()->role === 'admin') {
                return redirect('/admin/dashboard');
            }
            return redirect('/user/profile');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng',
        ]);
    }

    /**
     * LOGOUT
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
    public function showLogin(Request $request)
    {
        return view('auth.login');
    }
    public function showRegister(Request $request)
    {
        return view('auth.register');
    }
    public function showProfile(Request $request)
    {
        abort_unless(auth()->guard()->check(), 403);
        return view('users.profile', [
            'user' => auth()->guard()->user()
        ]);
    }
    public function showDashboard(Request $request)
    {
        abort_unless(auth()->guard()->check() && auth()->guard()->user()->role === 'admin', 403);
        return view('admin.dashboard', [
            'user' => auth()->guard()->user()
        ]);
    }
    //
    public function showReport(Request $request)
    {
        abort_unless(auth()->guard()->check() && auth()->guard()->user()->role === 'admin', 403);
        return view('admin.report', [
            'user' => auth()->guard()->user()
        ]);
    }
    //
    public function showPosts(Request $request)
    {
        abort_unless(auth()->guard()->check() && auth()->guard()->user()->role === 'admin', 403);
        return view('admin.posts.index', [
            'user' => auth()->guard()->user()
        ]);
    }
    //
    public function showAprovePosts(Request $request)
    {
        abort_unless(auth()->guard()->check() && auth()->guard()->user()->role === 'admin', 403);
        return view('admin.posts.approve', [
            'user' => auth()->guard()->user()
        ]);
    }
    //
    public function showCreatePost(Request $request)
    {
        abort_unless(auth()->guard()->check(), 403);
        return view('admin.posts.create', [
            'user' => auth()->guard()->user()
        ]);
    }
}