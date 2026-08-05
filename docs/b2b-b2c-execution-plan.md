> **⚠ Scope revised 2026-08-05 — see §10.** Everything below (§1–9) was written for the full marketplace vision and is now mostly superseded. Confirmed active scope is much smaller: **no public website changes at all, no subdomain/second app, just Super Admin / Agency Admin / Agent roles built around the existing `inquiries` table.** Sections 1-9 are kept as background/Phase-2+ backlog, not the active plan. Jump to §10 for what's actually being built now.

# Execution Plan — Building the Marketplace (Solo Build)

Companion to [umrahagency-b2b-b2c-plan.md](umrahagency-b2b-b2c-plan.md). That document is the *product vision*. This one is *how you actually build it*, given:

- You're building it **yourself**, not a 2-backend + 1-frontend + 1-QA team.
- The **enquiry form stays exactly as it is** — fields, validation, endpoint, markup. Nothing below touches it.
- This is being layered onto a **live production brochure site**, not a blank repo.

---

## 1. Reality check — what actually exists today

Checked directly against the codebase, not assumptions:

| Vision doc assumes | Codebase today |
|---|---|
| `packages`, `package_prices`, `hotels`, `seasons` tables | None. Each package page (`umrah-packages.html`, `hajj-packages.html`, etc.) is a **hardcoded Blade view** returned by `HomeController` |
| `agencies`, roles/tenancy, `spatie/laravel-permission` teams | None. One `AdminAuthController`, one implicit admin, no roles at all |
| `leads`, `lead_activities`, routing engine, SLA jobs | None. There's one `inquiries` table (`departure_airport`, `departure_date`, `hotel_category`, `duration`, `travelers`, `name`, `phone`, `email`, `message`) fed by a single `sendInquiry` endpoint |
| `agency_wallets`, `payments`, `invoices` | None |
| Countries/provinces/cities/areas as data | None — no location tables at all |

**Conclusion:** almost none of Section 3 (Data Model) exists yet. This is new-build work added *alongside* a working brochure site, not a refactor of existing tables. That's actually good news for a solo build — there's nothing fragile to untangle, and the current site can keep running unmodified while the new layer is built next to it.

---

## 2. Hard constraint for this pass

**The query/enquiry form does not change.** Not the fields, not the steps, not OTP, not the `inquiries` table, not `sendInquiry()`. Section 2.2 of the vision doc (the 3-step form redesign) is explicitly **out of scope** until you decide otherwise.

Everything below is designed to work *around* that constraint: new backend concepts (leads, agencies, packages) get built so they can consume what the current form already produces, not so they require changing it.

---

## 3. The one decision that has to happen first

Vision doc §0: same domain (hybrid/disclosed) vs a separate marketplace domain (their recommended Option B).

This determines whether you're standing up a **second Laravel project** or a **new module inside this one**. It's a business call, not a technical one, so it's not mine to make — but two notes so you can decide with your eyes open:

- If you pick **Option B (separate domain)**, everything from M1 onward happens in a fresh Laravel app. `umrahagency.pk` keeps running completely untouched, which is the safest option for your existing SEO and leads.
- If you pick **same domain**, the plan below still applies, just as new tables/routes/`admin`-style route group inside *this* repo instead of a second project.

Decide this before M1 — it changes where the code lives, not what gets built.

---

## 4. Build order (solo dev, not the 24-week team plan)

The vision doc's §10 delivery plan assumes 4 people working in parallel across a 24-week sprint. Solo, that ordering doesn't work — you need each milestone to be independently finishable, testable, and non-breaking to the live site before starting the next one. Suggested order:

### M0 — Quick wins (do this regardless of everything else, no schema needed)
Straight from the vision doc's §12 "Immediate Actions" — none of these depend on any architecture decision:
- Remove the ATOL paragraph from the footer (UK scheme, not applicable — legal exposure as-is)
- Fix the WhatsApp link to `wa.me/923251212747`
- Replace the UK airport list in the enquiry modal with Pakistani airports (data fix only — **not** a form redesign)
- Replace placeholder phone/office data with real data
- Publish your MoRA license number in the footer / About page

### M1 — Skeleton
New Laravel project (if Option B) or new namespaced module (if same domain). Get deploy/staging working before writing a single domain model — you don't want your first marketplace migration to also be your first deploy test.

### M2 — Location + master data
`countries → provinces → cities → areas`, `airports`, `hotels`. Pure data modeling, zero user-facing surface, nothing to break. Seed with real Pakistan data. This underpins everything else (pricing, routing, filters).

### M3 — Agencies + roles/tenancy scaffolding
`agencies` table, `spatie/laravel-permission` with teams enabled, the `BelongsToAgency` global-scope trait from §3. Create **your own agency as Agency #1** — you get a real tenant to build every later feature against instead of guessing.

### M4 — Packages data model
The single biggest content-modeling task: migrate the ~6 hardcoded package Blade views into `packages` / `package_prices` / `package_inclusions` / `package_itinerary` rows owned by Agency #1. This is where "brochure site" becomes "database-backed." Old public routes can keep their exact URLs — they just render from the DB instead of a hardcoded view, so SEO doesn't move.

### M5 — Leads pipeline (wraps the *existing* form, doesn't change it)
Add `leads` + `lead_activities` tables. `sendInquiry()` keeps writing to `inquiries` untouched — add a thin step that also creates a `leads` row from the same submitted data, auto-assigned to Agency #1 (there's only one agency right now, so routing/scoring logic from §2.5 can wait). This is where you get status lifecycle, activity timeline, and a real admin queue — without ever touching the form.

### M6 — Minimal agency/agent panel
Thin at first — you're the only agency, so this is really "a better admin for yourself": lead list, status changes, notes. Build only what §2.8/§2.9 describe that you'd actually use solo; skip wallet/billing UI entirely for now (no second agency yet, nothing to bill).

### M7 — WhatsApp notification on new lead
Independent of the marketplace work and probably your highest leverage single feature (§4.3) — new-lead alert to yourself via WhatsApp Cloud API/BSP. Worth doing right after M5, before M6, if you want a quick win.

### M8 — Only after M1–M7 are stable in production
This is where Phase 2 of the vision doc actually starts to make sense: self-service agency onboarding, KYC review, wallets/credits, public directory, second real agency pilot. Don't start this milestone until Agency #1 has been running through the full lead lifecycle for a while — you'll learn what's wrong with M2–M6 by using it yourself first.

---

## 5. Explicitly deferred (don't build yet)

- Query form redesign / OTP / progressive contact reveal (§2.2, §2.6) — frozen per §2 above
- Escrow, commission billing (§9 — vision doc itself says don't build commission-first)
- Native mobile app, click-to-call/SIP telephony, Nusuk integration
- Hajj module (different regulatory regime — vision doc explicitly says build separately)
- Anything in §5 (Phase 2) or §6 (Phase 3) before M8

---

## 6. Guardrails while building this solo, next to a live site

- Every migration is additive (new tables, nullable columns) — nothing alters or drops `inquiries`, `contact_clicks`, or existing views until the replacement is proven.
- New routes live behind an admin-only or unlisted path until a milestone is actually ready to go live — no half-built marketplace pages linked from the public site.
- Take a DB + files backup before each milestone that touches schema (M2 onward).
- Keep the current site's public URLs stable throughout — especially M4, where the temptation to "clean up" package URLs will be highest. Don't; the vision doc itself flags URL equity as something to protect (§4.4, §12).

---

## 7. Suggested next concrete step

Start with **M0** this week — it's zero-risk, doesn't depend on the domain decision, and clears the compliance/trust issues (ATOL text, fake airport list, placeholder contact info) called out as urgent in the vision doc's own §12. Decide §3 (domain) while M0 is in progress, then move to M1.

---

## 8. Deep dive — Section 2 (Phase 1 scope), item by item, §2.2 excluded

Confirmed against the codebase: no compare page, no tracking page, no i18n at all (`config/app.php` locale is just `env('APP_LOCALE', 'en')`, no `resources/lang`), no filter/browse logic. Everything in §2 is greenfield. The question worth answering per item isn't "does it exist" (it doesn't) but **"does this feature earn its cost while there is exactly one agency (you)?"** A lot of §2 exists specifically to referee *multiple competing agencies* — with one agency, that machinery has no one to referee.

### 2.1 B2C (excl. 2.2)

| Feature | Verdict | Why |
|---|---|---|
| Package browse & filter | Build in M4 | Direct payoff of packages moving to DB — this is the actual point of M4 |
| Package detail page | Build in M4 | Same — replaces the hardcoded per-page Blade views |
| Compare (up to 3) | Build shortly after M4 | Trivial once packages+prices are structured rows; needs nothing new |
| OTP verification | **Defer** | Tied to the form (§2.2), which is frozen |
| Query tracking page (`/track/{token}`) | Build in M5 | Doesn't touch the form — just needs a `tracking_token` on the new `leads` row created from existing submissions |
| SEO landing pages (`/umrah-packages/{city}`, `/{n}-days-from-{city}`) | **Pull forward, right after M2+M4** | Purely `locations × packages` — no agencies, roles, or leads required. Cheap, high SEO value, worth doing early rather than waiting for M8 |
| Urdu toggle (`ur`, RTL) | Defer to Phase 2 | Low code cost, high *content* cost (translating every page/policy) — not a blocker for the marketplace mechanics |
| WhatsApp CTA | Already ~done | M0 fixes the number; "platform-owned vs agency's" distinction is meaningless until there's a 2nd agency |

### 2.3 Roles & Permissions

Build the **schema** in M3 even though only one real tenant will use it. This is the one place where deferring is dangerous: retrofitting `agency_id` scoping onto live data later is the doc's own flagged risk ("one forgotten `where()` leaks a competitor's leads" — §3). Cheap to do now with one tenant, expensive to retrofit later.

Practical trim: you personally hold Super Admin + Agency Admin at once. Don't build a separate Agency Agent UI (§2.9) until you actually add a second user. Skip `agency_accountant` entirely — doc itself says add it later.

### 2.4 Lead Lifecycle

Build a **trimmed** state machine in M5, not the full 13-state one:
`NEW → CONTACTED → QUOTED → BOOKED → COMPLETED`, with `LOST / JUNK / DUPLICATE` as exits.

Skip `DOCUMENTS_PENDING`, `VISA_PROCESSING`, `VISA_APPROVED`, `VISA_REJECTED`, `TRAVELLED` until the bookings/traveller-documents module actually exists (Phase 2territory) — otherwise you're building UI states nothing will ever occupy.

Keep `lead_activities` (audit trail) from day one — it's a cheap insert-on-change and useful solo, not just for teams.

Don't enforce "`CONTACTED` requires a logged call" or "`QUOTED` requires a structured quote record" yet — those assume click-to-call and a quote-builder that don't exist. Log them as free-text notes for now; turn them into hard gates once M8's quote builder exists.

### 2.5 Lead Routing Engine

**Fully defer to Phase 2 (M8).** Matching, scoring, tie-break round-robin, and the SLA reassignment cascade all exist to pick *which of several agencies* gets a lead. With one agency, every lead goes to you — there's nothing to route.

The only thing worth keeping now: a simple **first-response timer** on your own dashboard (red if not contacted within N minutes). That's a computed field, not the queue/job infrastructure the doc describes — useful solo, costs almost nothing.

### 2.6 Anti-Leakage Controls

**Fully defer to Phase 2.** Every control here (progressive phone reveal, click-to-call, quote-in-platform requirement, watermarked exports, contractual terms) exists to keep *other* agencies honest with *your* leads. You can't leak a lead to yourself.

Partial exception: the 48h "did they contact you / was the price honoured" customer WhatsApp check is independently useful as a QA signal even solo — cheap to add once M7 (WhatsApp) exists, but it's polish, not core.

### 2.7 Super Admin — trim by group

| Group | Verdict |
|---|---|
| Agency management (onboarding, KYC, verification tiers, impersonation) | Defer — needs a 2nd agency |
| Payments & billing (wallets, credits, subscriptions, invoices) | Defer — needs someone to bill besides yourself |
| Locations CRUD | **Build in M2** (basic CRUD + seed). Defer "merge duplicates" tool and "serviceable-area map per agency" — those are multi-agency-scale problems |
| Master hotel DB + season calendar | **Build in M4** — you need structured hotels/seasons for your own packages anyway, solo or not |
| Package approval queue | Defer — you'd just be approving your own packages |
| Global lead inbox | **Build in M5/M6** — this is just your normal lead list with one tenant |
| Routing rule builder | Defer — depends on §2.5 |
| Junk/dispute queue, blacklist | Small version worth adding in M6 — cheap spam protection, useful even solo |
| Analytics: funnel (visits→submit→assigned→contacted→quoted→booked) | Worth a simple version once M5 exists — valuable with just your own data |
| Analytics: supply health / agency cohort retention | Defer — undefined with one agency |
| CMS/blog + SEO fields | **Independent workstream, can start anytime** — real SEO value, not gated on the marketplace build at all |
| Redirect manager | **Do alongside M4** — protects URL equity the moment any package URL changes, which the doc itself flags (§4.4, §12) as a real risk |
| Settings/feature flags, full audit log, role editor | Defer — Phase 2 admin polish |

### 2.8 Agency Admin — this is really "your own working panel"

Since you *are* Agency #1's admin, don't fully defer this section — but trim hard:

- **Build now (M6):** dashboard (today's leads, simple SLA flag, conversion), lead list with notes/timeline/follow-up reminders, package CRUD (this is M4), profile (logo/license/offices — cheap, doubles as future public agency-profile content)
- **Defer:** bulk assign/reassign (nothing to reassign between with one agency), agents management (no agents yet), wallet (nothing to bill yourself), business-hours routing settings (meaningless solo)
- **Judgment call, not automatic defer:** quote builder (PDF, branding, versioning) and bookings (traveller list, document checklist, payment schedule) are real operational value — but real effort too. If you're currently handling quotes/bookings fine over WhatsApp/manually, defer both to Phase 2/M8. If manual tracking is actively causing errors today, pull one of them forward — but treat that as a deliberate exception, not part of the default sequence.

### 2.9 Agent — Full Feature Set

**Zero Phase 1 value, fully defer.** This entire section only matters once a second person (an agent, or a second agency's admin) is actually using the system. Build it when you hire, not before.

---

## 9. When work can start — solo, full-time schedule

Basis: you're putting **30+ hrs/week** into this as your main focus (not squeezed around agency ops). Estimates below are for the *trimmed* Phase 1 scope from §8, not the full vision doc — that's what makes a ~12-week solo timeline realistic where the doc's own §10 plan needs 24 weeks with a 4-person team for a larger scope.

| Week | Dates (from today, 2026-08-05) | Work |
|---|---|---|
| 1 | Aug 5 – Aug 11 | **Start today.** M0 quick wins (1-2 days). Decide §3/§0 domain split this week — it gates M1 and everything after. Begin M1 skeleton. |
| 2 | Aug 12 – Aug 18 | Finish M1 (new project/module + staging deploy proven). Start M2 (locations + master data). |
| 3 | Aug 19 – Aug 25 | Finish M2 (seed real Pakistan provinces/cities/airports — this is the slow part, not the schema). Start M3 (agencies + roles/tenancy scaffolding, Agency #1 = you). |
| 4 | Aug 26 – Sep 1 | Finish M3. Start M4 (packages data model) — the largest single block. |
| 5–8 | Sep 2 – Sep 29 | M4: migrate the ~6 hardcoded package pages into DB rows, rebuild browse/filter/detail/compare, master hotel DB + season calendar, then (pulled forward per §8) SEO landing pages + redirect manager while location+package data is fresh in your head. |
| 9 | Sep 30 – Oct 6 | M5: leads pipeline — `leads`/`lead_activities`, wrap the existing (unchanged) form submissions, trimmed 5-state lifecycle, tracking page. |
| 10 | Oct 7 – Oct 13 | Finish M5 + buffer. Start M7 (WhatsApp): **submit your Meta message templates for approval on day one of this week** — that review can take days and shouldn't sit on your critical path later. |
| 11 | Oct 14 – Oct 20 | Finish M7. Start M6 (trimmed dashboard/lead list/notes/timeline/junk-dispute basics/funnel report/agency profile). |
| 12 | Oct 21 – Oct 27 | Finish M6, QA pass, soft-launch checkpoint — Phase 1 live and in daily use by you as Agency #1. |

**~12 weeks, live by late October 2026**, assuming no scope creep back into the deferred Phase-2 items in §8.

**Checkpoint before Phase 2 (M8):** don't put a date on it. Run Phase 1 in real daily use for at least 4-6 weeks first — the doc's own logic (§10 "Pilot before launch") applies to you as the first user, not just future agencies. Revisit the M8 start date once you've hit friction points worth fixing before onboarding a second agency.

**Risks to this schedule, specifically:**
- The 4-week window for M4 is the one most likely to slip — content modeling (turning loosely-written package pages into structured occupancy/hotel/season rows) is usually slower than the schema work around it.
- If "full-time" gets interrupted by actual agency operations (a real customer emergency, a season rush), treat weeks as elastic — the milestone order matters more than the calendar dates.

### Net effect on the M-milestone plan (§4)

This deep dive doesn't change M0–M5, but sharpens M6 and pulls two items forward:

- **M6** becomes: dashboard + lead list/notes/timeline + junk/dispute basics + simple funnel report + agency profile — not the full §2.7/§2.8 feature lists.
- **Pull forward, can start anytime independent of the milestone order:** CMS/blog content workstream (§2.7 Platform) and, once M2+M4 exist, programmatic SEO landing pages (§2.1) + redirect manager (§2.7 Platform) — none of these need agencies, roles, or leads.
- **Confirmed fully Phase 2 (M8), no Phase-1 version at all:** §2.5 (routing engine), §2.6 (anti-leakage), §2.7 agency-management/billing/trust groups, §2.8 wallet/agents, §2.9 (agent role) — these all exist to referee *multiple* agencies and have nothing to do while there's only one.

---

## 10. ACTIVE PLAN (2026-08-05) — Roles on queries only, nothing else

Scope correction from the user, overriding everything above: **no public website changes, no subdomain, no second app.** The entire build is: add Super Admin / Agency Admin / Agent roles to the existing Laravel app, working only on the existing `inquiries` table (the "queries" the current form already produces). Packages, locations, SEO pages, WhatsApp CTA, the public site — none of it is touched.

### 10.1 In / out, explicitly

| In | Out |
|---|---|
| `agencies` table (minimal) | Public agency directory, KYC, verification tiers |
| `role` + `agency_id` on `users` | spatie/laravel-permission, teams, granular permission editor |
| `agency_id`, `assigned_agent_id`, `status`, `lost_reason` added to `inquiries` | Any change to the public query form, its fields, or `sendInquiry()` |
| `inquiry_activities` audit trail | `leads`/`bookings`/`quotes` tables, packages, locations |
| Role-scoped admin views under the existing `/admin` prefix | New domain, subdomain, second Laravel app |
| Trimmed status lifecycle: `new → contacted → quoted → booked`, plus `lost`/`junk` | The 13-state lifecycle, SLA cascade, routing/scoring engine (§2.4/§2.5 — still N/A, still needs ≥2 real agencies competing) |

Confirmed against the code: `users` today has no `role` or `agency_id` column, `AdminAuthController` treats any authenticated user as full admin (no role check anywhere), and `InquiryController` is a flat, unscoped list. This is the exact gap being closed.

### 10.2 Data model (all additive — nothing in `inquiries` that the form writes to changes)

```
agencies              id, name, slug, is_active, timestamps

users                 + role   enum('super_admin','agency_admin','agent')  nullable
                      + agency_id  nullable FK → agencies  (null for super_admin)

inquiries             + agency_id          nullable FK → agencies
                      + assigned_agent_id  nullable FK → users
                      + status             enum('new','contacted','quoted','booked','lost','junk') default 'new'
                      + lost_reason        nullable string
                      + assigned_at        nullable timestamp

inquiry_activities    id, inquiry_id, user_id, type(status_change|note|assignment),
                      old_value, new_value, note, created_at
```

No new tables beyond `agencies` and `inquiry_activities`. Every existing column the form already writes (`departure_airport`, `name`, `phone`, etc.) is untouched.

### 10.3 Roles — simple column, not a permissions package

Three fixed roles, one app, no per-agency custom permission sets needed → a `role` enum on `users` plus a couple of Eloquent helper methods (`isSuperAdmin()`, `isAgencyAdmin()`, `isAgent()`) is proportionate. `spatie/laravel-permission` (as the original vision doc specs) would be the right call if you expected a 4th role or per-agency custom permissions later — skip it for now; it's an abstraction this scope doesn't need yet and it's a cheap package to add later if that changes.

**The one thing worth carrying over from the original tenancy design (§3 of the source vision doc):** put the agency-scoping in a **global Eloquent scope on `Inquiry`**, not in each controller — the doc's own warning stands regardless of package choice: a forgotten `where()` in one controller leaks another agency's queries. One scope, applied once, is safer than remembering it everywhere.

### 10.4 Access rules

| Capability | Super Admin | Agency Admin | Agent |
|---|:--:|:--:|:--:|
| See all inquiries, any agency | ✅ | — | — |
| See own agency's inquiries | ✅ | ✅ | — |
| See only inquiries assigned to self | ✅ | ✅ | ✅ |
| Assign inquiry → agency | ✅ | — | — |
| Assign inquiry → agent (within own agency) | ✅ | ✅ | — |
| Change status / add note | ✅ | ✅ | ✅ (assigned only) |
| Manage agencies (create/activate/deactivate) | ✅ | — | — |
| Create users (agency admins, agents) | ✅ | — (start here; revisit if agencies need self-service later) | — |

### 10.5 Routes & screens — same `/admin` prefix, no new domain

```
/admin/login, /admin/logout          unchanged
/admin/                              dashboard — content varies by role, same route
/admin/inquiries                     list — auto-scoped by the global scope per role
/admin/inquiries/{id}                detail — status change, notes, activity timeline, assign action (role-gated)
/admin/agencies                      super_admin only — CRUD
/admin/users                         super_admin only — create agency_admin/agent, assign to agency
```

`AdminAuthController` doesn't need new logic beyond what exists — login/logout mechanics are already role-agnostic. Add role checks as route middleware (Laravel's built-in `can`/Gate, keyed off the new `role` column) around the `agencies` and `users` route groups; the inquiries routes stay shared, with visibility narrowed by the model's global scope rather than by separate route groups.

### 10.6 Build order (linear — scope is small enough that milestone-jumping isn't needed)

| Step | Work | Est. (full-time) | Status |
|---|---|---|:--:|
| 1 | Migrations: `agencies`, `users` +role/+agency_id, `inquiries` +4 columns, `inquiry_activities` | 0.5 day | ✅ Done |
| 2 | Models: `Agency`, `InquiryActivity`, update `User` (role helpers) and `Inquiry` (relationships + global scope) | 0.5 day | ✅ Done |
| 3 | Role gates/middleware, route restructuring under existing `/admin` prefix | 0.5 day | ✅ Done |
| 4 | Seed a real Super Admin user + one Agency + one Agency Admin + one Agent for testing (this also finally closes the "no real admin credentials exist" gap) | 0.5 day | ✅ Done |
| 5 | Super Admin screens: Agencies CRUD, Users CRUD | 2 days | ✅ Done |
| 6 | Inquiries rework: agency/status/assigned columns + filters, assign-to-agency, assign-to-agent, status change + `lost_reason` dropdown, activity timeline | 3 days | ✅ Done |
| 7 | Dashboard per role (counts relevant to that role) | 1 day | ✅ Done |
| 8 | QA: write the test the source doc calls out — assert an Agency Admin/Agent can never see another agency's inquiry | 1 day | ✅ Done |

**~9 working days ≈ under 2 weeks full-time.** Realistic window: **Aug 5 – Aug 18, 2026.** All 8 steps landed on 2026-08-05 — faster than estimated, since B/C/D/E were built in a single continuous session rather than spread across two weeks.

Two things got fixed along the way that weren't in the original 8 steps, because building step 6/8 surfaced them directly:
- `inquiries.destroy` and the Contact Clicks routes had **no role restriction at all** in the pre-existing code (any logged-in user could delete a customer's query or view site-wide click analytics). Closed as part of the Agent work — both are now Super-Admin-only.
- A Super-Admin self-lockout guard: `UserController` blocks deleting your own account and locks your own role field when editing yourself, so the one seeded Super Admin can't accidentally strip their own access.

### 10.7 Open question worth deciding before Step 5

Does **Agency Admin** get self-service to create their own Agents, or does **Super Admin** create every user (simplest — start here, only 4 users likely at launch)? The schema in §10.2 supports either; it only changes whether a "create agent" screen exists under Agency Admin. Default recommendation: Super Admin creates everyone for now, revisit if/when a second agency's admin needs to onboard their own staff without waiting on you.

### 10.8 Guardrails (still apply)

- All migrations additive — nothing alters or drops existing `inquiries` columns or the `sendInquiry()` contract.
- No route, view, or asset under the public site changes as part of this work.
- Backup the DB before running the migrations in step 1, same as any schema change to a live table.

### 10.9 Status as of 2026-08-05 — what's left

All 8 build steps are done and verified (real HTTP requests, not just code review — see the 10 passing tests in `tests/Feature/InquiryTenancyScopeTest.php`). Everything below is what's **not** done yet:

| Item | Why it's not done | Blocking? |
|---|---|---|
| **Commit + push the work** | Every file above is still uncommitted, sitting only in the local working tree on `feature/agency-roles-admin`. Never pushed, never merged. | Yes — nothing survives a lost machine/branch until this happens |
| **Deploy to production (Hostinger)** | This was built and tested entirely against the local XAMPP dev DB. Production still runs the old flat, roleless admin panel. | Yes — none of A–E exists for real users yet |
| **Real `SUPER_ADMIN_EMAIL`/`SUPER_ADMIN_PASSWORD` in production `.env`** | Only set locally. The seeder needs its own real values on production before `php artisan db:seed` creates a usable production Super Admin login. | Yes — prerequisite to the point above |
| **First real Agency + real Agency Admin/Agent accounts** | Only the local `*@example.test` test fixtures exist. Nobody has created actual production agency/staff records yet. | Yes — the panel is empty/unusable for real work until this exists |
| **`CLAUDE.md` is still stale** | Flagged back when this build started — it still describes a static-HTML site and has unfilled placeholders in §0. Never updated to reflect the Laravel 12 reality or this new role system. | No — but every future session pays the re-discovery cost until it's fixed |
| **No self-service password reset** | Super Admin sets a user's password directly when creating/editing them; there's no "forgot password" flow for Agency Admins/Agents. Deliberately out of scope for §10, not an oversight — worth deciding if it's needed before real staff start using this. | No, unless a real non-owner user needs it |
| **CRUD test coverage for Agencies/Users controllers** | Only the tenancy-isolation behavior got a formal test suite (E). Agency/User create-edit-delete happened via manual HTTP smoke tests during B, not permanent tests. | No — manually verified, just not regression-guarded |

**Immediate next step, if you want this live:** commit the branch, then decide whether to merge straight to `main` or open a PR for review — that's the one call left before this can actually reach production.
