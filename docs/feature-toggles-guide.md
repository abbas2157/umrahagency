# Per-Agency Feature Toggles — As-Built Guide

Lets Super Admin switch a whole feature module on or off for one specific agency, without
affecting any other agency. Built as reusable infrastructure — the first (and so far only)
feature wired into it is Salary & Commission, but adding the next one is a three-step change,
not a new system. Verified against the running app (tinker-driven: toggled off → route
blocked → toggled on → route passes → reset → blocked again) and `php artisan test`.

---

## 1. How it works

- **`App\Support\Feature`** is the registry — a plain PHP class listing every togglable
  feature by key, with a label, a description, and a coded default (`default_enabled`). This
  is the only place a new feature gets registered; there's no database table of "possible
  features" because only a developer adds a new feature module, not Super Admin.
- **`agency_feature_overrides`** is the only table involved, and it only holds *deviations*
  from a feature's coded default — one row per `(agency_id, feature_key)` where Super Admin
  has explicitly flipped it away from default. An agency with no rows here is just using
  every feature's coded default. Most agencies will have zero rows.
- **`Agency::hasFeature($key)`** is the one method everything else calls: override row wins if
  one exists, otherwise the registry default applies.
- **`feature:{key}` middleware** (`App\Http\Middleware\EnsureFeatureEnabled`, aliased
  `feature`) blocks a route group for any agency without that feature enabled. Super Admin is
  never gated — they can always reach an agency's screens regardless of that agency's
  toggles. A blocked request gets a friendly "Feature Not Enabled" page
  (`resources/views/errors/feature-disabled.blade.php`), not a bare 403.
- **Nav links wrapped in the same `hasFeature()` check** — a disabled feature disappears from
  the sidebar, it doesn't just 403 if clicked.

## 2. Toggling a feature (Super Admin)

1. Go to **Agencies** → open an agency (`/admin/agencies/{agency}`).
2. The **Features** section lists every registered feature with an On/Off button and a note
   showing whether it's on the coded default or has been manually overridden.
3. Click the button to flip it — logs to `ActivityLog` (`feature_enabled` / `feature_disabled`)
   scoped to that agency, same convention as every other mutating admin action (CLAUDE.md §8).
4. If overridden, a **Reset to default** link appears — deletes the override row so the agency
   falls back to whatever the registry says, rather than pinning a value forever.

## 3. What "disabled" actually does

Existing data is never touched or hidden from the database — a disabled feature just becomes
unreachable through the UI and routes while it's off. Re-enabling it makes everything visible
again exactly as it was. This was a deliberate simplicity choice over, say, read-only access
while disabled — flagged to the user as a trade-off worth knowing, not silently assumed.

## 4. Adding a new togglable feature (for the next one you build)

1. Add one entry to `App\Support\Feature::all()` — key, label, description, `default_enabled`.
2. Wrap its route group in `routes/agency.php` (or wherever it lives) with
   `Route::middleware('feature:'.\App\Support\Feature::YOUR_KEY)->group(...)`.
3. Wrap its sidebar link(s) in `resources/views/layouts/agency.blade.php` with
   `@if(auth()->user()?->agency?->hasFeature(\App\Support\Feature::YOUR_KEY))`.

No new controller, table, or admin screen needed — the toggle UI on the Agency show page
already lists every registered feature automatically (`Feature::all()` drives that loop), and
`AgencyFeatureController` already handles toggling/resetting any key that exists in the
registry.

## 5. Current default state

`salary_commission` defaults to **off** for every agency — it must be explicitly switched on
per agency by Super Admin. This was a deliberate choice (opt-in rollout, not a kill-switch) —
worth knowing if this default is ever revisited for a future feature: not every feature needs
to default off, `default_enabled` is per-feature in the registry.
