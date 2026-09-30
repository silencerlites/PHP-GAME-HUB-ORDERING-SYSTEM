<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    public function login(LoginRequest $request)
    {
        if (! Auth::attempt($request->validated(), $request->boolean('remember'))) {
            return back()->withErrors(['email'=>'Invalid email or password.'])->onlyInput('email');
        }
        $request->session()->regenerate();
        if ($request->user()->status !== 'active') {
            Auth::logout();
            return back()->with('error', 'Your account is inactive.');
        }
        return redirect()->intended($this->homeFor($request->user()->role));
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            'name'=>$data['name'], 'email'=>$data['email'], 'password'=>$data['password'],
            'role'=>'customer', 'status'=>'active',
        ]);
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->route('customer.catalog')->with('success', 'Welcome to GameHub!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    private function homeFor(string $role): string
    {
        return match ($role) {
            'admin' => route('admin.dashboard'),
            'staff' => route('staff.dashboard'),
            default => route('customer.catalog'),
        };
    }
}
