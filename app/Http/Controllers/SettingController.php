<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('settings.index', [
            'preference' => $user->preference,
            'accounts' => $user->accounts()->get(),
            'unreadCount' => $user->bankNotifications()->unread()->count(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:180', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:40'],
            'address' => ['nullable', 'string', 'max:180'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'current_password' => ['nullable', 'string'],
            'password' => ['nullable', 'confirmed', 'min:10'],
        ]);

        $changingSensitive = ! empty($data['password']) || $data['email'] !== $user->email;

        if ($changingSensitive && empty($data['current_password'])) {
            throw ValidationException::withMessages([
                'current_password' => 'Enter your current password to change your email or password.',
            ]);
        }

        if ($changingSensitive && ! Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'That is not your current password.',
            ]);
        }

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
        ]);

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        return back()->with('success', 'Your profile has been updated.');
    }

    public function updatePreferences(Request $request)
    {
        $user = Auth::user();
        $preference = $user->preference;

        $data = $request->validate([
            'balances_visible_by_default' => ['nullable', 'boolean'],
            'login_alerts' => ['nullable', 'boolean'],
            'payment_alerts' => ['nullable', 'boolean'],
            'promotional_emails' => ['nullable', 'boolean'],
            'paperless_statements' => ['nullable', 'boolean'],
            'statement_format' => ['required', Rule::in(['pdf', 'html'])],
            'time_zone' => ['required', 'string', 'max:64'],
        ]);

        $preference->update([
            'balances_visible_by_default' => $request->boolean('balances_visible_by_default'),
            'login_alerts' => $request->boolean('login_alerts'),
            'payment_alerts' => $request->boolean('payment_alerts'),
            'promotional_emails' => $request->boolean('promotional_emails'),
            'paperless_statements' => $request->boolean('paperless_statements'),
            'statement_format' => $data['statement_format'],
            'time_zone' => $data['time_zone'],
        ]);

        return back()->with('success', 'Your preferences have been saved.');
    }
}
