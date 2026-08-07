<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\SetLocale;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route($this->homeRouteFor(Auth::user()));
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            ActivityLog::record('login_failed', "Failed login attempt for '{$credentials['email']}'");

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        $user = Auth::user();

        if (! $user->isSuperAdmin() && $user->agency && ! $user->agency->is_active) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Your agency has been deactivated. Contact the platform administrator.',
            ])->onlyInput('email');
        }

        if (! $user->is_active) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'Your account has been deactivated. Contact your agency admin.',
            ])->onlyInput('email');
        }

        $user->forceFill([
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ])->save();

        // A language picked on the login screen (guest, session-only) is a
        // clear signal of intent — carry it onto the account itself so it
        // sticks for every future login, not just this one page load.
        $preLoginLocale = $request->session()->get('locale');
        if (in_array($preLoginLocale, SetLocale::SUPPORTED, true) && $preLoginLocale !== $user->locale) {
            $user->update(['locale' => $preLoginLocale]);
        }

        ActivityLog::record('login', "{$user->name} logged in", $user->agency_id, 'User', $user->id);

        $request->session()->regenerate();

        return redirect()->intended(route($this->homeRouteFor($user)));
    }

    /**
     * One shared login for every role; where they land after it differs —
     * Super Admin gets the platform-wide admin panel, Agency Admin/Agent
     * get their own agency panel.
     */
    private function homeRouteFor($user): string
    {
        return $user->isSuperAdmin() ? 'admin.dashboard' : 'agency.dashboard';
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            ActivityLog::record('logout', "{$user->name} logged out", $user->agency_id, 'User', $user->id);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
