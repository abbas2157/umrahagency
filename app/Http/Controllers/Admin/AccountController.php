<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Support\UserAgentParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function show(Request $request)
    {
        $sessions = $this->sessionsFor($request->user()->id, $request->session()->getId());

        return view('admin.account.show', [
            'user' => $request->user(),
            'sessions' => $sessions,
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'current_password' => ['required', 'current_password'],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }
        unset($validated['current_password']);

        $user->update($validated);

        ActivityLog::record('profile_updated', "{$user->name} updated their own profile", $user->agency_id, 'User', $user->id);

        return back()->with('success', 'Profile updated.');
    }

    public function revokeSession(Request $request, string $sessionId)
    {
        if ($sessionId === $request->session()->getId()) {
            return back()->withErrors(['session' => "Use Logout to end your current session — this is for other devices."]);
        }

        DB::table('sessions')
            ->where('user_id', $request->user()->id)
            ->where('id', $sessionId)
            ->delete();

        ActivityLog::record('session_revoked', "{$request->user()->name} logged out one of their own devices", $request->user()->agency_id, 'User', $request->user()->id);

        return back()->with('success', 'Device logged out.');
    }

    public function revokeOtherSessions(Request $request)
    {
        DB::table('sessions')
            ->where('user_id', $request->user()->id)
            ->where('id', '!=', $request->session()->getId())
            ->delete();

        ActivityLog::record('session_revoked', "{$request->user()->name} logged out all other devices", $request->user()->agency_id, 'User', $request->user()->id);

        return back()->with('success', 'All other devices have been logged out.');
    }

    /**
     * @return \Illuminate\Support\Collection<int, array{id: string, device: string, ip_address: ?string, last_active: \Illuminate\Support\Carbon, is_current: bool}>
     */
    private function sessionsFor(int $userId, string $currentSessionId)
    {
        return DB::table('sessions')
            ->where('user_id', $userId)
            ->orderByDesc('last_activity')
            ->get()
            ->map(fn ($session) => [
                'id' => $session->id,
                'device' => UserAgentParser::describe($session->user_agent),
                'ip_address' => $session->ip_address,
                'last_active' => now()->setTimestamp($session->last_activity),
                'is_current' => $session->id === $currentSessionId,
            ]);
    }
}
