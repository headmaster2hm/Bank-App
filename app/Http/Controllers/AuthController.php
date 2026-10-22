<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'password' => ['required', 'confirmed', Password::min(8)],
            'date_of_birth' => 'required|date|before:-18 years',
            'address' => 'required|string|max:255',
            'ssn_last_four' => 'required|string|size:4|digits:4',
            'terms' => 'required',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'date_of_birth' => $validated['date_of_birth'],
            'address' => $validated['address'],
            'ssn_last_four' => $validated['ssn_last_four'],
        ]);

        // Create default accounts
        \App\Models\Account::create([
            'user_id' => $user->id,
            'account_number' => \App\Models\Account::generateAccountNumber(),
            'account_type' => 'checking',
            'account_name' => 'Premium Checking',
            'balance' => 5000.00,
            'available_balance' => 5000.00,
        ]);

        \App\Models\Account::create([
            'user_id' => $user->id,
            'account_number' => \App\Models\Account::generateAccountNumber(),
            'account_type' => 'savings',
            'account_name' => 'High-Yield Savings',
            'balance' => 10000.00,
            'available_balance' => 10000.00,
            'interest_rate' => 4.50,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
