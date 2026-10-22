<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class SecurityController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('security.index', [
            'devices' => $user->trustedDevices()->orderByDesc('last_used_at')->get(),
            'events' => $user->securityEvents()->orderByDesc('occurred_at')->limit(15)->get(),
            'preference' => $user->preference,
            'suspiciousCount' => $user->securityEvents()->where('is_suspicious', true)->count(),
            'unreadCount' => $user->bankNotifications()->unread()->count(),
        ]);
    }

    public function toggleTwoFactor()
    {
        $user = Auth::user();
        $preference = $user->preference;

        $preference->update(['two_factor_enabled' => ! $preference->two_factor_enabled]);

        if ($preference->two_factor_enabled) {
            $user->securityEvents()->create([
                'event_type' => 'two_factor_enabled',
                'title' => 'Two-step verification enabled',
                'location' => 'Online banking',
                'device_name' => 'This browser',
                'occurred_at' => now(),
            ]);
        }

        return back()->with('success', $preference->two_factor_enabled
            ? 'Two-step verification marked as on for this demonstration account. No code will be requested at sign-in in this prototype.'
            : 'Two-step verification has been turned off.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::min(10)->letters()->numbers()],
        ]);

        if (! Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'That is not your current password.',
            ]);
        }

        $user->update(['password' => $data['password']]);

        $user->securityEvents()->create([
            'event_type' => 'password_change',
            'title' => 'Password changed',
            'location' => 'Online banking',
            'device_name' => 'This browser',
            'occurred_at' => now(),
        ]);

        return back()->with('success', 'Your password has been changed.');
    }

    public function revokeDevice(Request $request, $device)
    {
        $trustedDevice = Auth::user()->trustedDevices()->findOrFail($device);

        if ($trustedDevice->isCurrent()) {
            return back()->with('error', 'You cannot remove the device you are currently using. Sign out on other devices instead.');
        }

        $trustedDevice->delete();

        return back()->with('success', $trustedDevice->device_name . ' was removed from your trusted devices.');
    }
}
