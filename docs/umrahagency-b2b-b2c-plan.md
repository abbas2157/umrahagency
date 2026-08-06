# UmrahAgency.pk — B2B + B2C Marketplace Plan

**Stack:** Laravel 11/12, Blade + Bootstrap 5, MySQL 8, Redis
**Market (Phase 1):** Pakistan only — Country → Province → City → Area
**Document version:** 1.0

---

## 0. The Strategic Decision You Must Make First

Right now `umrahagency.pk` is a **single-agency brochure site**. You are proposing to turn it into a **marketplace**. These two business models conflict, and you need to resolve the conflict before writing code.

**The problem:** if you list competitor agencies AND sell your own packages on the same domain, every agency you onboard will assume (correctly) that you give your own packages the best placement. They will not trust you with their leads.

**Three options:**

| Option | Description | Verdict |
|---|---|---|
| **A. Pure marketplace** | You stop selling directly. Revenue = agency fees only. | Cleanest trust story, but you kill existing revenue on day one. |
| **B. Split brands** | `umrahagency.pk` stays your own agency. New domain (e.g. `umrahbazar.pk`, `hajjumrah.pk`) is the marketplace. | **Recommended.** Protects existing SEO + revenue, gives the marketplace a neutral identity. |
| **C. Hybrid, disclosed** | One domain, your own agency listed as just another agency, clearly labelled "Owned by platform". | Works only if ranking rules are transparent and auditable. Hard to sustain. |

**Recommendation: Option B.** Build the platform as a separate Laravel application with its own domain. Your existing agency becomes *Agency #1* inside it — which is perfect, because you get a real tenant to test every feature against before onboarding strangers.

The rest of this document assumes the platform is a distinct application.

---

## 1. Industry Problems → Product Response

This is the section that separates a working platform from a generic CRM. Every feature below exists to solve a specific, real problem in the Pakistani Umrah trade.

| # | Industry problem | What it looks like in practice | Product response |
|---|---|---|---|
| 1 | **Lead leakage** | Agent gets the customer's number, closes the deal on personal WhatsApp, agency/platform never sees it | Progressive contact reveal, click-to-call logging, in-app quote requirement, post-lead customer feedback loop |
| 2 | **Price staleness** | PKR prices go stale in days due to SAR/PKR movement + airfare volatility | Every price row has `valid_until`; expired packages auto-flip to "Price on Request"; SAR base + PKR display with configurable FX |
| 3 | **Fake/bait pricing** | Agency advertises PKR 180,000, quotes PKR 240,000 on the phone | Quote must be submitted in-platform; customer confirms "was the quoted price honoured?"; quote-variance score affects ranking |
| 4 | **Unlicensed operators** | Sub-agents with no MoRA license take advance payments and vanish | Mandatory KYC: MoRA/Hajj Group Organizer license, NTN, CNIC, office proof. Verified badge. License number on every listing. |
| 5 | **Advance payment fraud** | Customer pays 50% cash, agency disappears or downgrades hotel | Phase 3 escrow. Phase 1: platform never touches customer money — be explicit about this in T&Cs to avoid liability. |
| 6 | **Slow response** | Lead sits unanswered for 6 hours, customer books elsewhere | SLA timer per lead (default 15 min), auto-reassign on breach, response-time visible on agency profile |
| 7 | **Departure-city pricing** | A Multan customer is quoted a Lahore price, then hit with a surcharge | `departure_city` is a first-class pricing dimension, not a note |
| 8 | **Seasonality** | Ramadan prices are 2–3× off-peak; last-10-days even higher | Season calendar table with per-season price multipliers and separate inventory |
| 9 | **Occupancy confusion** | "PKR 180,000/pp" — but is that quad, triple, double? | Price is stored per occupancy (Single/Double/Triple/Quad/Sharing). No single headline price without occupancy. |
| 10 | **Hotel distance ambiguity** | "Near Haram" means 200m to one agency and 2km to another | Hotel entity stores `distance_from_haram_meters` + walking/shuttle flag. Displayed on every card. |
| 11 | **Inclusion ambiguity** | Is Ziyarat included? Meals? Which meals? Transport type? | Structured inclusions matrix (boolean + detail per item), not free-text |
| 12 | **Document chaos** | Passport scans on WhatsApp, lost, expired, wrong vaccination | Document checklist per traveller with expiry validation (passport ≥ 6 months, ACWY certificate) |
| 13 | **Visa rejection** | Customer already paid; who bears the cost? | Explicit refund policy per package, stored structurally; rejection is a lifecycle state with its own workflow |
| 14 | **Language barrier** | Small-town customers and agents are Urdu-first | Full Urdu UI (`ur` locale, RTL) from Phase 1. Not an afterthought. |
| 15 | **Low digital literacy of agencies** | Owner is 55, uses only WhatsApp | WhatsApp-based lead notification with deep link into platform. Mobile-first agency panel. Onboarding call + video. |
| 16 | **Commission unenforceability** | Bookings close in cash, offline — you can't verify or collect % | **Do not build commission-first.** Lead credits + subscription. (See §9.) |
| 17 | **Duplicate/junk leads** | Same customer submits 5 forms; competitors submit fake leads | Dedup on phone+package within 72h; OTP verification on phone; lead credit refund on verified-junk dispute |
| 18 | **Regulatory drift** | Saudi rules (Nusuk, visa validity, vaccination) change frequently | Rules stored as configurable content, not hardcoded. Named owner reviews quarterly. |

---

## 2. Phase 1 — Scope

**Goal:** a working two-sided flow. Customer submits a query → routed to the right agency → agency's agent works it → outcome recorded. Plus everything needed to bill agencies.

### 2.1 B2C (Customer-facing, no login required)

| Feature | Notes |
|---|---|
| Package browse & filter | Filters: departure city, nights, star rating, occupancy, month, budget range, Makkah/Madinah split |
| Package detail page | Hotels with distance, day-wise itinerary, structured inclusions/exclusions, refund policy, agency license number |
| Compare (up to 3) | Side-by-side table — big conversion driver |
| **Query form** | The core B2C action. Fields in §2.2 |
| OTP verification | SMS OTP on phone before lead is created. Kills 80% of junk. |
| Query tracking page | Public URL + token: `/track/{token}` — customer sees quotes received, no login needed |
| SEO landing pages | Programmatic: `/umrah-packages/{city}`, `/{nights}-days-umrah-from-{city}`, `/ramadan-umrah-packages` |
| Urdu toggle | `ur` locale, RTL stylesheet |
| WhatsApp CTA | Platform-owned number, not agency's |

### 2.2 The Query Form (design this carefully — it's your product)

**Step 1 — What you want**
- Package type: Umrah / Hajj / Custom / Visa only
- Preferred travel month (or exact date, or "flexible")
- Nights: total + Makkah/Madinah split preference
- Hotel category: 3★ / 4★ / 5★ / Economy
- Occupancy: Single / Double / Triple / Quad / Sharing
- Travellers: adults / children (2–12) / infants (0–2)
- Budget per person (range slider)

**Step 2 — Where you are**
- Country (locked to Pakistan in Phase 1, but modelled properly)
- Province → City → Area (cascading dropdowns)
- **Departure airport** (separate field — a Bahawalpur resident may fly from Multan or Lahore)

**Step 3 — Who you are**
- Full name, phone (OTP), email (optional), WhatsApp same as phone? (checkbox)
- Preferred contact method + preferred contact time
- Notes / special requirements (wheelchair, elderly, first-time)

> Keep it three short steps with a progress bar. Every extra field costs ~5% completion. Save partial submissions after Step 1 so an abandoned form is still a recoverable lead.

### 2.3 Roles & Permissions

Use `spatie/laravel-permission` **with teams enabled** (team = agency).

| Capability | Super Admin | Agency Admin | Agency Agent |
|---|:--:|:--:|:--:|
| Manage agencies (create/suspend/verify) | ✅ | — | — |
| Approve/reject KYC documents | ✅ | — | — |
| Manage locations (province/city/area) | ✅ | — | — |
| Manage master hotels, airlines, airports | ✅ | — | — |
| Configure lead routing rules & pricing | ✅ | — | — |
| View all leads across all agencies | ✅ | — | — |
| View own agency's leads | ✅ | ✅ | assigned only* |
| Assign / reassign leads | ✅ | ✅ | — |
| Change lead status | ✅ | ✅ | ✅ |
| Create/submit quotes | — | ✅ | ✅ |
| Approve quotes above threshold | — | ✅ | — |
| Create & manage agents | ✅ | ✅ | — |
| Create/edit agency packages | ✅ | ✅ | optional flag |
| Publish package (goes live) | ✅ (moderation) | ✅ | — |
| Buy lead credits / manage subscription | — | ✅ | — |
| View agency wallet & invoices | ✅ | ✅ | — |
| Agency-level reports | ✅ | ✅ | own only |
| Platform-wide reports | ✅ | — | — |
| Impersonate agency user (audited) | ✅ | — | — |
| Manage CMS, blog, SEO | ✅ | — | — |
| Access audit log | ✅ | own agency | — |

\* *Agency Admin can toggle "agents see unassigned pool" — some agencies want first-come-first-serve.*

**Add a 4th role later: `agency_accountant`** (wallet + invoices only, no lead access). Small addition, agencies ask for it constantly.

### 2.4 Lead Lifecycle

```
NEW → ASSIGNED → CONTACTED → QUOTED → NEGOTIATING → BOOKED
                                                       ↓
                              DOCUMENTS_PENDING → VISA_PROCESSING
                                                       ↓
                                    VISA_APPROVED → TRAVELLED → COMPLETED
                                          ↓
                                    VISA_REJECTED

Terminal-negative: LOST | JUNK | DUPLICATE | EXPIRED
```

**Mandatory loss reasons** (dropdown, not free text — you need this data):
`Price too high` · `Booked with another agency` · `Dates changed` · `Not reachable after N attempts` · `Just browsing` · `Budget not ready` · `Wanted unavailable hotel` · `Visa concern` · `Other (required note)`

**Rules:**
- Every status change writes to `lead_activities` with actor, timestamp, old→new, note.
- `CONTACTED` requires a logged call or WhatsApp send — it cannot be self-declared with no evidence.
- `QUOTED` requires an actual quote record with amount and occupancy.
- `BOOKED` requires booking amount + advance received — this is your revenue reporting basis later.

### 2.5 Lead Routing Engine (your competitive moat)

**Exclusive-with-reclaim model.** Send the lead to ONE agency. If they don't act within the SLA, reclaim it and route to the next.

Do *not* copy the Indian/Pakistani property-portal model of selling one lead to 5 agencies — the customer gets 5 calls in 10 minutes, hates the experience, and never returns. Exclusive routing is your marketing message: *"One agency. One call. No spam."*

**Matching order:**
1. **Hard filters** — agency active, KYC verified, has credit balance, serves customer's city, offers requested package type
2. **Scoring** — weighted, all weights configurable by Super Admin:
   - Response time (last 30 days) — 30%
   - Conversion rate — 20%
   - Customer rating — 20%
   - Package match closeness (nights/star/budget) — 15%
   - Subscription tier boost — 10%
   - Capacity headroom (open leads vs. agent count) — 5%
3. **Tie-break** — round-robin so the same agency doesn't take everything

**SLA cascade:**
| Stage | Timer | Action |
|---|---|---|
| Assigned | 0 min | WhatsApp + SMS + in-app push to agency admin & assigned agent |
| No open | 5 min | Reminder + escalate to agency admin |
| No contact logged | 15 min | Reclaim → route to agency #2, credit refunded to agency #1 |
| No contact logged (#2) | 15 min | Route to agency #3 |
| No agency responds | 45 min | Escalate to Super Admin queue + auto-SMS customer: "we're finding you the best option" |

Implement with `dispatch()->delay()` jobs on Redis + Horizon.

### 2.6 Anti-Leakage Controls

Rank-ordered by effectiveness/effort ratio:

1. **Progressive reveal** — agency sees name, city, requirement, budget. Phone is masked (`0300-XXX-4521`) until they click **Accept Lead**, which debits the credit and logs intent.
2. **Click-to-call from panel** — agent dials via the platform. You get call duration and recording. (Pakistani providers: Jazz Business, Nayatel, or a SIP/Asterisk setup.)
3. **Quote-in-platform requirement** — a lead cannot advance past `CONTACTED` without a structured quote. No quote = no credit refund on dispute, and it damages the agency score.
4. **Customer feedback loop** — 48h after lead assignment, automated WhatsApp to customer: *"Did [Agency] contact you? Was the price they quoted the same as on our site?"* This catches both non-response and bait pricing. Answers feed the agency score.
5. **Watermarked exports** — any lead CSV export carries an invisible per-agency marker (row order salt + a canary row). If your lead list surfaces elsewhere, you know the source.
6. **Contractual** — the agency agreement makes off-platform diversion grounds for suspension and forfeiture of wallet balance.

### 2.7 Super Admin — Full Feature Set

Beyond your four:

**Agency management**
- Onboarding wizard, KYC document review with approve/reject + reason
- Verification tiers: `Unverified` → `Documents Submitted` → `Verified` → `Premium Partner`
- Suspend/reactivate with reason; suspension immediately halts routing
- **Impersonation** ("Login as agency") — fully audit-logged. Your support team will live in this.

**Payments & billing**
- Agency wallets: credit/debit ledger, never a mutable balance column
- Lead credit pricing (per-lead cost by tier/city/package value)
- Subscription plans (create, assign, prorate, expire)
- Manual payment verification queue (bank transfer receipt upload → verify → credit wallet). **This is the primary flow in Pakistan.**
- Invoice + FBR-compliant tax invoice generation, withholding tax handling
- Refunds & credit adjustments with mandatory reason
- Dunning: low-balance alerts at 3, 1, 0 credits

**Locations**
- Country → Province → City → Area, sortable/searchable, soft-delete-safe
- Merge duplicates tool (you *will* accumulate "Lahore"/"lahore"/"Lhr")
- Serviceable-area map per agency
- Airport master separate from cities, mapped many-to-many

**Content & catalogue moderation**
- Package approval queue before publish (prevents nonsense listings)
- Master hotel database — agencies pick from your list, not free-text. Non-negotiable for filtering to work.
- Airline, airport, visa-type masters
- Season calendar (Ramadan, last-10-days, Rajab, Shaban, Muharram, off-peak) with date ranges per Hijri year

**Lead operations**
- Global lead inbox with filters; manual reassign; refund credit
- Routing rule builder; per-city overrides
- Junk/dispute resolution queue
- Blacklist (phone/IP/email)

**Trust & safety**
- Review moderation queue
- Complaint/dispute case management (customer vs agency)
- Fraud flags: agencies with high quote variance, low response, spike in disputes

**Analytics**
- Funnel: visits → form starts → submits → OTP verified → assigned → contacted → quoted → booked
- Revenue: MRR, ARPA, credit burn rate, churn
- Supply health: agencies per city, coverage gaps ("no verified agency in Sukkur")
- Lead quality by source/campaign (UTM captured at form)
- Cohort retention of agencies

**Platform**
- CMS (pages, blog, FAQ), SEO fields per entity, redirect manager (critical when you migrate from `.html` URLs)
- Notification template editor (WhatsApp/SMS/email), per-locale
- Settings: FX rate, SLA timers, scoring weights, feature flags
- Global audit log
- Role & permission editor

### 2.8 Agency Admin — Full Feature Set

- **Dashboard:** today's leads, SLA at-risk (red), credit balance, conversion this month vs last, agent leaderboard
- **Leads:** list with saved filters, bulk assign, reassign, status change, notes, file attachments, full activity timeline, follow-up reminders with calendar view
- **Quotes:** build a quote from a package or from scratch; PDF generated with agency branding; send via WhatsApp/email; versioning; expiry date; accept/reject tracking
- **Packages:** create/edit/clone, per-occupancy and per-departure-city pricing, seasonal price rules, bulk price update (they will change all prices when the dollar moves — give them a bulk tool or they'll quit), publish/unpublish, expiry
- **Agents:** invite by email/phone, set role, assign serviceable cities, set daily lead cap, activate/deactivate, per-agent performance
- **Bookings:** convert lead → booking, traveller list, document checklist per traveller with expiry warnings, payment schedule (advance/balance), visa status tracking
- **Wallet:** balance, transaction history, buy credits, upload payment proof, invoices, auto-recharge toggle
- **Profile:** logo, description, license numbers, offices, photos, working hours, WhatsApp number, bank details
- **Reports:** lead source, loss reason breakdown, agent performance, revenue, response-time trend
- **Settings:** business hours (leads route away when closed — or to a night queue), auto-assignment rules within the agency, notification preferences, quote approval threshold

### 2.9 Agent — Full Feature Set

Keep it deliberately narrow. Agents are high-turnover; a wide panel is a data-leak surface.

- **My Leads** — assigned only, sorted by SLA urgency with a countdown
- **Lead detail** — requirement, customer name/city, contact revealed on accept, notes, activity timeline
- **Actions** — accept, click-to-call, WhatsApp (templated), log call outcome, change status, set follow-up reminder, attach file
- **Quote builder** — pick package → adjust → submit (auto-routes to admin if above threshold)
- **My performance** — leads handled, response time, conversion, this month vs target
- **Explicitly excluded:** bulk export, other agents' leads, wallet, package pricing edit, agency settings

---

## 3. Data Model (Phase 1 core tables)

```
── Identity & Tenancy ──────────────────────────────────
users                 id, name, email, phone, password, agency_id (nullable),
                      is_active, last_login_at, locale
agencies              id, name, slug, license_no_mora, license_no_iata, ntn,
                      owner_cnic, logo, description, status(pending|active|
                      suspended|rejected), verification_tier, city_id,
                      address, whatsapp, response_score, conversion_score,
                      rating_avg, rating_count, subscription_plan_id,
                      subscribed_until, created_at
agency_documents      id, agency_id, type(mora_license|ntn|cnic|office_proof|
                      bank_letter), file_path, status, reviewed_by,
                      reviewed_at, rejection_reason, expires_at
agency_serviceable_areas  agency_id, city_id  (or area_id)
roles / permissions / model_has_roles   (spatie, team_id = agency_id)

── Locations ───────────────────────────────────────────
countries             id, name, iso2, phone_code, currency, is_active
provinces             id, country_id, name, is_active
cities                id, province_id, name, slug, is_active, seo_title,
                      seo_description   ← powers landing pages
areas                 id, city_id, name, is_active
airports              id, city_id, iata_code, name, country_id, is_departure

── Catalogue ───────────────────────────────────────────
hotels                id, holy_city(makkah|madinah), name, star_rating,
                      distance_from_haram_m, walking_distance(bool),
                      shuttle_available, address, images, is_active
packages              id, agency_id, title, slug, type(umrah|hajj|custom|visa),
                      total_nights, makkah_nights, madinah_nights,
                      makkah_hotel_id, madinah_hotel_id, star_rating,
                      visa_type, transport_type, airline_id, meal_plan,
                      ziyarat_included, valid_from, valid_to,
                      status(draft|pending|published|expired), is_featured
package_prices        id, package_id, departure_airport_id, occupancy(single|
                      double|triple|quad|sharing), price_pkr, price_sar,
                      child_price, infant_price, season_id, valid_until
                      ← composite unique(package_id, airport, occupancy, season)
package_inclusions    id, package_id, item_key, is_included, detail
package_itinerary     id, package_id, day_no, title, description
seasons               id, name, hijri_year, starts_on, ends_on, multiplier

── Leads ───────────────────────────────────────────────
leads                 id, reference_no, tracking_token, name, phone,
                      phone_verified_at, email, whatsapp, country_id,
                      province_id, city_id, area_id, departure_airport_id,
                      package_type, package_id(nullable), travel_month,
                      travel_date, flexible(bool), nights, makkah_nights,
                      madinah_nights, star_rating, occupancy, adults,
                      children, infants, budget_min, budget_max, notes,
                      preferred_contact, preferred_time, source, utm_source,
                      utm_campaign, ip, user_agent,
                      status, lost_reason, agency_id, assigned_agent_id,
                      assigned_at, first_response_at, sla_due_at,
                      reassign_count, created_at
lead_activities       id, lead_id, user_id, type(status_change|call|whatsapp|
                      email|note|quote_sent|assignment), old_value, new_value,
                      note, meta(json), created_at
lead_assignments      id, lead_id, agency_id, agent_id, assigned_at,
                      accepted_at, expired_at, outcome, credit_charged
quotes                id, lead_id, agency_id, agent_id, package_id, version,
                      occupancy, price_per_person, total_price, currency,
                      inclusions_snapshot(json), valid_until,
                      status(draft|sent|viewed|accepted|rejected|expired),
                      pdf_path, sent_at, viewed_at
lead_feedback         id, lead_id, was_contacted, price_matched,
                      rating, comment, submitted_at

── Bookings & Documents ────────────────────────────────
bookings              id, lead_id, agency_id, booking_no, total_amount,
                      advance_amount, balance_due_on, status, travel_date,
                      pnr, visa_status, created_at
travellers            id, booking_id, full_name, cnic, passport_no,
                      passport_expiry, dob, gender, relation, is_mahram_for,
                      nusuk_id, visa_no, visa_issued_at
traveller_documents   id, traveller_id, type(passport|cnic|photo|vaccination|
                      visa|ticket), file_path, expires_at, verified_at

── Billing ─────────────────────────────────────────────
subscription_plans    id, name, price_monthly, price_yearly, lead_credits,
                      max_agents, max_packages, boost_weight, features(json)
agency_wallets        id, agency_id, balance_credits, balance_pkr,
                      auto_recharge, low_balance_threshold
wallet_transactions   id, agency_id, type(credit|debit|refund|adjustment),
                      amount, credits, balance_after, reference_type,
                      reference_id, note, created_by, created_at
payments              id, agency_id, amount, method(bank_transfer|jazzcash|
                      easypaisa|card), gateway_ref, receipt_path,
                      status(pending|verified|rejected), verified_by,
                      verified_at
invoices              id, agency_id, invoice_no, period_from, period_to,
                      subtotal, tax, total, status, pdf_path

── Trust ───────────────────────────────────────────────
reviews               id, agency_id, booking_id, customer_name, rating,
                      title, comment, status(pending|approved|rejected),
                      moderated_by
disputes              id, lead_id/booking_id, agency_id, raised_by, type,
                      description, status, resolution, resolved_at
activity_log          (spatie/laravel-activitylog)
```

**Multi-tenancy approach:** single database, `agency_id` column, enforced by a **global Eloquent scope** on every tenant model plus a middleware that sets the current tenant. Never rely on controller-level filtering alone — one forgotten `where()` leaks a competitor's leads.

```php
// app/Models/Concerns/BelongsToAgency.php
protected static function bootBelongsToAgency(): void
{
    static::addGlobalScope('agency', function (Builder $q) {
        if (auth()->check() && ! auth()->user()->isSuperAdmin()) {
            $q->where($q->getModel()->getTable().'.agency_id', auth()->user()->agency_id);
        }
    });

    static::creating(function ($model) {
        if (! $model->agency_id && auth()->check()) {
            $model->agency_id = auth()->user()->agency_id;
        }
    });
}
```

Write a test that asserts every tenant model has the trait. It will save you.

---

## 4. Technical Architecture

### 4.1 Application layout

Three separate route/middleware groups, one codebase:

```
routes/web.php          → B2C public site
routes/agency.php       → agency.domain.pk or /agency  (agency admin + agent)
routes/admin.php        → /superadmin                  (super admin)
```

Middleware stack per group: `auth`, `role:*`, `EnsureAgencyActive`, `SetTenant`, `EnsureHasCredits` (on lead-accept routes only).

### 4.2 Recommended packages

| Concern | Package |
|---|---|
| Roles & permissions | `spatie/laravel-permission` (teams mode) |
| Audit log | `spatie/laravel-activitylog` |
| Media | `spatie/laravel-medialibrary` |
| Admin scaffolding | **Filament v3** for Super Admin panel — saves ~6 weeks. Build the agency panel custom in Blade/Bootstrap for full UX control. |
| Queues | Redis + `laravel/horizon` |
| Real-time | `laravel/reverb` (self-hosted WebSockets — new lead toast, no polling) |
| PDF | `spatie/laravel-pdf` (Browsershot) or `barryvdh/laravel-dompdf` |
| Search | MySQL FULLTEXT initially; Meilisearch when packages > 5k |
| Excel | `maatwebsite/excel` |
| Backups | `spatie/laravel-backup` → offsite S3/Wasabi, daily |
| Errors | Sentry |
| Frontend interactivity | **Livewire 3** — pairs well with Blade + Bootstrap, avoids a separate SPA |

### 4.3 Integrations

**WhatsApp — the single most important integration.** In Pakistan, WhatsApp *is* the channel.
- Use **WhatsApp Cloud API** (Meta) directly, or a BSP (360dialog, Twilio, Interakt).
- Get templates pre-approved: `new_lead_agency`, `lead_sla_warning`, `quote_sent_customer`, `lead_feedback_request`, `low_balance_agency`, `booking_confirmed`.
- Two-way webhook: agency replies "1" → lead auto-accepted. Reduces friction enormously for low-tech agencies.

**SMS** — local aggregator (Veevo, BizSMS, Telenor Corporate) for OTP. Register your masking ID with PTA. Keep a second provider as failover; OTP delivery failure = zero leads.

**Payments (agency-side only in Phase 1):**
| Method | Notes |
|---|---|
| Bank transfer + receipt upload | **Primary.** Build the manual verification queue first — most agencies will use this. |
| JazzCash | Merchant API, widest reach |
| Easypaisa | Merchant API |
| Safepay / PayFast (PK) | Card acquiring; Stripe is not available in Pakistan |

**Email** — Amazon SES or Mailgun. Configure SPF/DKIM/DMARC before the first send.

**Currency** — daily FX pull (`exchangerate.host` or SBP rate), stored in `fx_rates`. Never hit the API at request time.

**Calls** — Phase 2. SIP trunk + Asterisk/FreePBX for click-to-call and recording, or a local cloud PBX.

### 4.4 Non-functional

- **Performance:** package listing must render < 1.5s on 3G. Cache filter facets in Redis. Eager-load aggressively; add an N+1 detector in local (`beyondcode/laravel-query-detector`).
- **Images:** WebP + responsive `srcset` + lazy loading. You're already on WebP — good.
- **Security:** encrypt passport/CNIC fields at rest (`encrypted` cast); rate-limit the query form (5/hour/IP); reCAPTCHA v3 or Turnstile; signed URLs for documents; 2FA mandatory for Super Admin; force HTTPS + HSTS.
- **SEO migration:** your current `.html` URLs have equity. Build a `redirects` table and 301 every old URL to its new counterpart. Keep `/umrah-packages.html` working.
- **Structured data:** `Product` + `Offer` + `AggregateRating` + `FAQPage` JSON-LD on package pages. `LocalBusiness` on agency profiles.
- **Backups:** daily DB + media, offsite, with a **restore drill** every quarter. An untested backup is not a backup.
- **Environments:** local → staging → production. No direct production edits.

---

## 5. Phase 2 — Agency Marketplace & Directory

**Goal:** shift from "you manually onboard agencies" to "agencies sign themselves up and pay you."

### 5.1 Self-service onboarding

```
Register → Email/phone OTP → Business profile → Upload KYC
  → Admin review (SLA: 24h) → Approved → Choose plan → Pay → Live
```

**Required documents:**
- MoRA / Hajj Group Organizer license (with number and expiry — auto-warn 30 days before expiry, auto-suspend on expiry)
- NTN certificate
- Owner CNIC (front/back)
- Office proof (utility bill / rent agreement)
- Bank account letter (for future escrow)
- IATA/TIDA certificate (optional, boosts tier)

### 5.2 Public agency directory

- `/agencies` — filter by city, verification tier, rating, package type, price range
- `/agency/{slug}` — profile: license number displayed prominently, verification badge, packages, reviews, response time, years active, offices, photos
- **Verified badge with meaning** — hover shows exactly what was verified and when. A badge nobody understands builds no trust.

### 5.3 Reviews & trust

- Reviews only from leads that reached `BOOKED` or `TRAVELLED` — verified-purchase only. Open reviews get gamed within a month.
- Rating dimensions: value for money, hotel as promised, communication, visa/document handling
- Agency can respond publicly once per review
- Moderation queue; automatic flag on profanity or contact-info-in-review

### 5.4 Subscription tiers (illustrative — validate pricing with 10 real agencies first)

| | Free | Basic | Growth | Premium |
|---|---|---|---|---|
| Monthly (PKR) | 0 | 5,000 | 15,000 | 40,000 |
| Included leads | 3 | 25 | 100 | 300 |
| Extra lead | 800 | 600 | 450 | 350 |
| Agents | 1 | 3 | 10 | Unlimited |
| Packages | 3 | 15 | 60 | Unlimited |
| Directory placement | Bottom | Standard | Boosted | Top + homepage |
| Featured packages | — | — | 2 | 8 |
| Analytics | Basic | Basic | Advanced | Advanced + export |
| Support | Email | Email | WhatsApp | Dedicated manager |
| API access | — | — | — | ✅ |

### 5.5 Phase 2 additions

- Package comparison across agencies
- Saved searches + price-drop alerts (email/WhatsApp)
- Customer accounts (optional) — query history, saved packages, documents
- Blog/content engine for SEO (this industry is won on search)
- Referral program for agencies
- Bulk package import (CSV/Excel) — agencies with 100+ packages will not hand-enter them

---

## 6. Phase 3+ — Roadmap

| Priority | Feature | Why |
|---|---|---|
| High | **Escrow / secure payment** | Platform holds advance, releases on visa issuance. Solves the #1 customer fear. Requires SBP-compliant partner. |
| High | **Native mobile app** (agency-side first) | Agents live on phones. Push notifications beat WhatsApp for SLA. |
| High | **Real-time inventory** | Move from "quote on request" to actual bookable seats/rooms |
| Medium | Hajj module | Different regulatory regime, quota system, Ministry balloting — build separately, don't force it into the Umrah model |
| Medium | Sub-agent network (B2B2B) | Let agencies onboard their own sub-agents. Matches how the market actually works. |
| Medium | Group booking / corporate | Companies and mosques book 40+ pilgrims |
| Medium | Ancillaries | Ziyarat tours, transport-only, travel insurance, SIM, forex, ihram kits — high margin |
| Medium | Agency API | Push packages from their existing system; a real retention lever |
| Low | Nusuk Masar integration | Currently limited third-party access — monitor the Saudi API roadmap |
| Low | Expansion: India, Bangladesh, UK, Indonesia | Location model already supports it — that's why Country is in the schema from day one |
| Low | Flight/hotel aggregator feeds | Only once volume justifies it |

---

## 7. Compliance & Legal

**Pakistan**
- Umrah operators must be licensed by the **Ministry of Religious Affairs**; verify and display license numbers. As a platform you are an intermediary — say so explicitly in your T&Cs.
- **Remove the ATOL text from your footer immediately.** ATOL is a UK CAA scheme; claiming it in Pakistan is misrepresentation.
- PTA rules for SMS masking and marketing consent
- FBR: sales tax on services registration, withholding on agency payments
- Personal Data Protection legislation is evolving — build for consent capture, data retention limits, and deletion requests now rather than retrofitting.
- Consumer protection: your published prices must match what agencies actually quote. This is a legal exposure, not just a UX issue.

**Saudi Arabia** (informational, keep as editable content — it changes often)
- Umrah visas are issued through Saudi-approved systems; agencies need a Saudi counterpart
- Passport validity requirements, meningococcal ACWY vaccination, insurance bundled with the visa
- Visa validity/stay duration and rules for women travelling without a mahram have changed multiple times in recent years — **assign an owner to review these quarterly** and never hardcode them.

**Platform documents you need before Phase 2:**
Agency Agreement · Customer T&Cs · Privacy Policy · Refund & Cancellation Policy · Lead Credit Policy (what counts as junk, when credits are refunded) · Dispute Resolution Policy · Acceptable Use Policy

---

## 8. KPIs

**Marketplace health**
- Verified agencies per city (coverage gaps = lost leads)
- Packages published; % with current prices
- Lead-to-agency ratio (too many agencies per lead = churn; too few = poor customer experience)

**Lead quality**
- Form start → submit rate (target > 45%)
- OTP verification rate (target > 80%)
- Junk rate (target < 8%)
- Median first-response time (target < 10 min)
- SLA breach rate (target < 15%)
- Lead → quote (target > 60%) · Quote → booking (target > 20%)

**Commercial**
- MRR, ARPA, credit burn rate
- Agency churn (target < 8%/month — anything above and the product isn't delivering)
- CAC per agency and per lead
- Contribution margin per lead

**Trust**
- Quote variance (advertised vs quoted) — target < 10%
- Dispute rate, resolution time
- NPS of customers and of agencies (track separately; they diverge)

---

## 9. Monetization — Be Realistic

**Do not build commission-on-booking first.** In Pakistan, Umrah deals close over WhatsApp and settle in cash. You cannot verify a booking happened, and agencies will under-report. You'll build an elaborate billing system that collects nothing.

**Recommended sequence:**

1. **Phase 1 — Lead credits (pay-per-lead).** Simple, verifiable, aligned. The agency pays for something you demonstrably delivered. Price a lead at roughly 1–2% of average package value (PKR 250k package → PKR 300–600/lead). Refund credits on genuine junk — generously at first, to build trust.
2. **Phase 2 — Subscription + included credits.** Converts lumpy revenue into MRR and increases switching costs.
3. **Phase 2 — Advertising.** Featured placement, homepage slots, seasonal campaign boosts (Ramadan slots are genuinely scarce — auction them).
4. **Phase 3 — Commission**, but only *after* escrow exists. Once money flows through you, commission becomes enforceable rather than aspirational.
5. **Ongoing — Value-added services.** Verification-as-a-service, agency websites, SEO packages, training.

---

## 10. Delivery Plan (~24 weeks, 2 backend + 1 frontend + 1 designer/QA)

| Sprint | Weeks | Deliverable |
|---|---|---|
| 0 | 1–2 | Decisions locked (§0), wireframes, DB schema finalised, Laravel skeleton, CI/CD, staging |
| 1 | 3–4 | Auth, roles/permissions, tenancy scope, Super Admin shell (Filament), location CRUD + seeded PK data |
| 2 | 5–6 | Agency CRUD, KYC upload/review, agent management, agency panel shell |
| 3 | 7–9 | Package module: hotels master, packages, per-occupancy/per-airport pricing, inclusions, seasons, moderation |
| 4 | 10–12 | B2C: listing, filters, detail, compare, query form + OTP, tracking page |
| 5 | 13–15 | Lead engine: routing, scoring, SLA jobs, assignment, activity log, agent panel |
| 6 | 16–17 | WhatsApp + SMS + email notifications, templates, two-way webhook |
| 7 | 18–19 | Quotes + PDF, bookings, traveller documents, follow-up reminders |
| 8 | 20–21 | Wallet, credits, manual payment verification, subscriptions, invoices |
| 9 | 22 | Reports & dashboards (all three roles) |
| 10 | 23 | SEO: landing pages, schema.org, sitemap, 301 redirect map from old `.html` URLs |
| 11 | 24 | Security review, load test, UAT with 3 pilot agencies, launch |

**Then Phase 2 (weeks 25–40):** self-service onboarding, directory, reviews, subscription automation, comparison, alerts, blog.

**Pilot before launch.** Onboard 3–5 real agencies in weeks 22–24 for free. Watch them use it. Half your assumptions about how they work will be wrong, and it's far cheaper to learn that before you've sold subscriptions.

---

## 11. Top Risks

| Risk | Mitigation |
|---|---|
| **Cold start** — no agencies means no leads means no agencies | Launch city-by-city. Lahore first (you're based there). Sign 15 agencies before opening B2C in that city. Give 60 days free. |
| **Agencies bypass the platform** | §2.6 controls + make the CRM genuinely useful, so leaving costs them their workflow, not just their leads |
| **You compete with your own tenants** | Resolve via §0 Option B |
| **Junk leads destroy agency trust** | OTP mandatory, generous credit refunds early, publish your junk rate openly |
| **Price disputes / bait pricing** | Quote-in-platform + customer feedback loop + variance score + suspension policy |
| **Seasonality cashflow** | Annual subscriptions with a Ramadan-season discount; smooth revenue across off-peak |
| **Regulatory change (Saudi or MoRA)** | Configurable rules, quarterly review owner, never hardcode |
| **Scope creep** | Phase 1 ships lead routing and billing. Nothing else. Escrow, apps, and Hajj are Phase 3 — write that down and defend it. |

---

## 12. Immediate Actions (this week)

1. Decide §0 — one domain or two. Everything else depends on it.
2. Remove the ATOL paragraph from the footer.
3. Fix the WhatsApp link → `wa.me/923251212747`.
4. Replace the UK airport list in the enquiry modal with Pakistani airports.
5. Replace `+92-XXX-XXXXXXX` and the empty office-locations placeholder with real data.
6. Publish your MoRA license number in the footer and on the About page.
7. Call 10 agency owners in Lahore. Ask three questions: *How many leads do you buy monthly and from whom? What do you pay? What makes you stop paying?* Their answers should override any pricing in §5.4.
