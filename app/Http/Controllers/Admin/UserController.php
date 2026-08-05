<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Agency;
use App\Models\User;
use App\Support\UserAgentParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('agency')->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $agencies = Agency::orderBy('name')->get();

        return view('admin.users.create', compact('agencies'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateUser($request);

        $user = User::create($validated);

        ActivityLog::record('user_created', "User '{$user->name}' ({$user->role}) created", $user->agency_id, 'User', $user->id);

        return redirect()->route('admin.users.index')->with('success', 'User created.');
    }

    public function edit(User $user)
    {
        $agencies = Agency::orderBy('name')->get();

        return view('admin.users.edit', compact('user', 'agencies'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $this->validateUser($request, $user);

        // Editing yourself: keep your own role fixed so the only Super Admin
        // in the system can't accidentally demote or lock themselves out.
        if ($user->is(auth()->user())) {
            $validated['role'] = $user->role;
            $validated['agency_id'] = $user->agency_id;
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        ActivityLog::record('user_updated', "User '{$user->name}' updated", $user->agency_id, 'User', $user->id);

        return redirect()->route('admin.users.index')->with('success', 'User updated.');
    }

    public function destroy(User $user)
    {
        if ($user->is(auth()->user())) {
            return back()->withErrors(['user' => 'You cannot delete your own account.']);
        }

        ActivityLog::record('user_deleted', "User '{$user->name}' deleted", $user->agency_id, 'User', $user->id);

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted. Any queries assigned to them are now unassigned.');
    }

    public function sessions(User $user)
    {
        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderByDesc('last_activity')
            ->get()
            ->map(fn ($session) => [
                'id' => $session->id,
                'device' => UserAgentParser::describe($session->user_agent),
                'ip_address' => $session->ip_address,
                'last_active' => now()->setTimestamp($session->last_activity),
            ]);

        return view('admin.users.sessions', compact('user', 'sessions'));
    }

    public function revokeSession(User $user, string $sessionId)
    {
        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', $sessionId)
            ->delete();

        ActivityLog::record('session_revoked', "A device belonging to '{$user->name}' was logged out", $user->agency_id, 'User', $user->id);

        return back()->with('success', 'Device logged out.');
    }

    private function validateUser(Request $request, ?User $user = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'password' => [$user ? 'nullable' : 'required', 'confirmed', 'min:8'],
            'role' => ['required', Rule::in(['super_admin', 'agency_admin', 'agent'])],
            'agency_id' => [
                Rule::requiredIf($request->input('role') !== 'super_admin'),
                'nullable',
                'exists:agencies,id',
            ],
        ]);

        if ($validated['role'] === 'super_admin') {
            $validated['agency_id'] = null;
        }

        return $validated;
    }
}
