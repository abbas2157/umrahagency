# Travel Product Layer — Implementation Plan

**System:** UmrahAgency.pk Management Platform
**Module code:** `travel_product`
**Total estimate:** 15.5 weeks (10 weeks to minimum shippable slice)

---

## Phase 0 — Foundation (1.5 weeks)

Nothing else can start until the switch layer is ready.

- Upgrade `features` table: add `parent_key`, `default_enabled`, `group`, `sort_order`
- Add `plan_features` — feature bundles per subscription tier + numeric limits
- Change `agency_features.state` to three-state: `null` = inherit from plan, `1` = force on, `0` = force off
- Add `feature_toggle_logs` — immutable audit of every toggle
- Build `FeatureService` with parent → child resolution and per-agency cache
- Enforcement at five layers: route middleware, Blade `@feature`, nav config registry, policies, scheduled jobs
- Super Admin screen: Agencies → {Agency} → Features (tree view, impact-summary modal on disable)
- Permissions seeder for all new roles
- Migrate money columns to integer minor units

**Decision required in week 1:** extend the existing `bookings` table, or create `travel_bookings` + a sync adapter.

**Feature keys registered**

```
travel_product                      (parent module)
├── travel_product.suppliers
├── travel_product.packages
├── travel_product.departures
├── travel_product.pilgrims
├── travel_product.bookings
├── travel_product.quotations
└── travel_product.profitability
```

---

## Phase 1 — Catalog (2 weeks)

- Suppliers: hotel, transport, ground handler, airline, visa processor
- Hotels with distance-from-Haram, star rating, shuttle info, amenities
- Hotel contracts + seasonal rate cards (allocation vs. on-request, release days)
- Packages: type, duration, Makkah/Madinah night split, category, inclusions/exclusions, bilingual
- Package variants (occupancy × pax type) with separate cost price and sell price
- Package addons: ziyarat, extra baggage, laundry
- Public website listing wired to `is_published`

**Gates:** `travel_product.packages`, `travel_product.suppliers`

---

## Phase 2 — Departures & inventory (2 weeks)

- Departures: dated instance of a package, flight details, PNRs, group leader, ground handler
- Seat inventory by occupancy with row-level locking (`SELECT … FOR UPDATE`)
- Held-seat TTL (48h) with auto-release job
- Departure cost sheet by category, with estimated vs. actual flag
- FX rate lock at departure level
- Deadline alert job: name-change, ticket payment, allotment release, visa cutoff, minimum-pax shortfall
- Departure calendar view + public "seats remaining" display

**Gate:** `travel_product.departures`

---

## Phase 3 — Pilgrims & documents (2 weeks)

- Pilgrim master record: passport, CNIC/NICOP, DOB, medical, mobility, repeat-trip counter
- Pilgrim relations table for mehram / family linkage
- Configurable `document_types` per agency — nothing hardcoded, rules change
- Encrypted document upload, served only via signed authorised routes
- Verification workflow: pending → uploaded → verified / rejected / expired
- Validation rules: passport 6-month validity, meningitis ACYW135, polio certificate, Saudi photo spec, child birth certificate, mehram proof

**Gate:** `travel_product.pilgrims`

---

## Phase 4 — Bookings (2.5 weeks)

- Booking record with snapshotted pricing, agent attribution, source, cancellation policy
- `booking_pax` — one row per traveller, with visa status, Mofa number, Nusuk reference, ticket number
- Booking state machine with guards: deposit threshold, documents complete, visa issued, ticket deadline
- Visa processing kanban, separate from the sales pipeline
- Full stage history audit trail
- Name-change / pax replacement tracking
- Integration with the existing payments + commission engine, per the Phase 0 decision

**Hard constraint:** commission earned on past payments must keep working when `travel_product` is switched off. The dependency runs one way only — travel → commission, never the reverse.

**Gate:** `travel_product.bookings`

---

## Phase 5 — Quotations (1.5 weeks)

- Quotation builder from package/departure or custom line items
- Versioning with parent/child revisions
- Bilingual branded PDF (Nastaleeq font — prototype in week 1, not here)
- Shareable public link with view tracking
- WhatsApp share
- Inquiry → quotation → booking conversion flow

**Gate:** `travel_product.quotations`

---

## Phase 6 — Operations (1.5 weeks)

- Room creation and pax assignment per city
- Rooming list generator
- Manifest exports for airline, ground handler, MoRA
- Group leader (Amir-e-Qafila) view of his departure

**Gate:** `travel_product.departures`

---

## Phase 7 — Profitability (1.5 weeks)

- Departure P&L: cost sheet vs. realised revenue
- Margin by package, hotel, agent, sub-agent
- FX exposure report — SAR/USD cost vs. PKR sale
- Agent performance metrics extended: conversion by package, average booking value, on-time document collection

**Gate:** `travel_product.profitability`

---

## Phase 8 — Documentation & hardening (1 week)

- `docs/travel-product-layer.md` — data model, state machines, business rules
- `docs/feature-flags.md` — resolution order, five enforcement layers, checklist for adding future modules
- Bilingual user guide for agency staff
- ERD export
- Demo seeder: 3 packages, 5 departures, 40 bookings, 120 pilgrims
- Security review of document storage
- Load test on inventory concurrency

---

## Timeline

| Phase | Weeks | Cumulative |
|---|---|---|
| 0 — Foundation | 1.5 | 1.5 |
| 1 — Catalog | 2.0 | 3.5 |
| 2 — Departures | 2.0 | 5.5 |
| 3 — Pilgrims & Documents | 2.0 | 7.5 |
| 4 — Bookings | 2.5 | 10.0 |
| 5 — Quotations | 1.5 | 11.5 |
| 6 — Operations | 1.5 | 13.0 |
| 7 — Profitability | 1.5 | 14.5 |
| 8 — Docs & hardening | 1.0 | 15.5 |

**Minimum shippable slice:** Phases 0–4 (10 weeks). Phases 5–7 ship incrementally behind their own sub-feature flags.

---

## Behaviour when the switch is turned OFF

| Concern | Behaviour |
|---|---|
| Data | Retained, never deleted |
| UI / routes / API | Hidden; return 404, not 403 |
| Payments & commission already earned | Unaffected |
| Scheduled jobs | Skipped per agency |
| Public website | Falls back to static content |
| Re-enabling | Restores everything exactly as it was |
| Super Admin | Can still export a disabled agency's data for support |

The disable confirmation modal must show a live impact count — packages, open departures, seats sold, bookings in processing — and require a written reason.

---

## Adding future modules — reusable checklist

1. Insert a row into `features` with `key`, `parent_key`, `default_enabled`
2. Add entries to `config/navigation.php`
3. Wrap routes in `feature:your.key`
4. Add the feature check as the first line of each policy method

No changes to the flag system itself.
