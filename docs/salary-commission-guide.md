# Salary & Commission — As-Built Guide

Covers the full lifecycle of the Salary & Commission module: bookings, payments, commission
accrual, compensation plans, payroll runs, and agent advances. Everything below was verified
against the running app (tinker scripts driving real controllers/views, plus `php artisan
test`) — nothing here is aspirational. Source spec: `docs/SALARY-COMMISSION.md` (the original
build prompt); this doc describes what was actually shipped, which deviates from that spec in
a few deliberate places, called out inline.

**Access:** this whole module sits behind a per-agency feature toggle (see
`docs/feature-toggles-guide.md`) named `salary_commission`, **off by default**. Super Admin
must switch it on for an agency (`/admin/agencies/{agency}` → Features section) before any of
the screens below become reachable for that agency. Bookings/Payments are shared between
Agency Admin and Agent; Compensation Plans, Commissions, Payrolls, and Advances are Agency
Admin only; My Earnings is Agent only.

---

## 1. Bookings

`/agency/bookings` — both roles, scoped: Agency Admin sees every booking in their agency,
Agent sees only bookings where they're the assigned agent.

1. **Create** (`/agency/bookings/create`): optionally link an existing query (only queries not
   already linked to a booking are offered), pick a package tier (3-star / 4-star / 5-star /
   visa-only), total price (PKR), optional cost price (PKR — needed only for margin-based
   commission plans, see §3), and booking date. Agency Admin can assign any agent in the
   agency; an Agent creating their own booking is auto-assigned to themselves.
2. **View** (`/agency/bookings/{id}`): shows total price, amount received, balance due, linked
   query, payments list, and any commissions accrued against it.
3. **Edit**: same fields as create; an Agent can edit their own booking's details but cannot
   reassign it to another agent.
4. **Cancel** (Agency Admin only): sets `status = cancelled`. Never deleted — payments and
   commissions still point to it. A cancelled booking stops earning new commission but its
   history stays visible.

**Deviation from spec:** `Booking` and `Payment` were not in the original SALARY-COMMISSION.md
schema — that doc assumed bookings already existed via Inquiry's `status = 'booked'`. They
were built fresh this pass (confirmed with the user first) because commission needs a real
amount, a real payment date, and a real paying agent, none of which Inquiry carries.

---

## 2. Payments

Recorded from a booking's show page, not a separate screen.

1. **Record a payment**: amount, date received, method (free text), optional reference.
   Immediately triggers commission accrual (§3) if the booking's agent has an active
   commission-bearing compensation plan.
2. **Refund** (Agency Admin only): flips the payment's status to `refunded` — the row is never
   deleted. Triggers a commission reversal (§3) for whatever was accrued against that payment.

---

## 3. Commission accrual

**Core rule (from the spec, preserved exactly): commission accrues on money received, not on
bookings made.** Each payment earns its own slice of commission, proportional to how much of
the booking's total price that payment covers.

Three commission types (set on the compensation plan, §4):

| Type | Formula per payment |
|---|---|
| `percent_sale` | `payment_amount × commission_rate / 100` |
| `percent_margin` | `payment_amount × ((total_price − cost_price) / total_price) × commission_rate / 100` — pays **0** until `cost_price` is filled in on the booking |
| `fixed_per_tier` | `tier_amount × (payment_amount / total_price)` — the tier's flat PKR amount, earned in proportion to how much of the booking has been paid off |

Every accrual is one row in `commissions` (status `accrued`). **The ledger is append-only** —
a refund never edits or deletes the original row. It inserts a new negative row instead
(status `reversed`), linked to the same payment.

**Refund clawback rule:** a reversal only gets swept into a payroll run if the commission it's
reversing was itself already `approved` or `paid`. If the original was refunded before an
Agency Admin ever approved it, the reversal is simply left unswept — nothing was ever going to
be paid out for it, so there's nothing to claw back. This was a real bug caught and fixed
during build: the first version silently dropped reversals of already-paid commissions,
which would have overpaid the agent.

**Approval** (`/agency/commissions`, Agency Admin only): moves a commission from `accrued` to
`approved` — the checkpoint before it can be pulled into a payroll. `reversed` and `paid` are
end states; only `accrued` rows show an Approve button.

---

## 4. Compensation Plans

`/agency/compensation-plans` — Agency Admin only.

1. **Create/Edit**: name, type (`salary` / `commission` / `salary_commission`), base salary
   (PKR/month, if the type includes salary), and — if the type includes commission — a
   commission type (§3) with either a flat rate (percent-based) or a per-tier PKR amount
   (fixed-per-tier).
2. **Deactivate/Activate**: stops the plan being offered for new assignments; agents already on
   it keep their current assignment untouched (deactivate-never-delete, same as everywhere
   else in the codebase).
3. **Assign to an agent**: pick a plan and an effective-from date. If the agent already has an
   open-ended assignment, it's closed off the day before the new one starts — **rate changes
   are never retroactive**, the old assignment row is never edited or backdated over.

**Deviation from spec:** `target_rules` (tiered sales targets) and `share_percent` (split
commissions between multiple agents) from the original schema were deliberately left out —
scoped out of Phase 1 with the user up front.

---

## 5. Payroll

`/agency/payrolls` — Agency Admin only. A payroll run is generated for a calendar month and
moves through a strict state machine: **draft → approved → paid**.

1. **Generate** (`/agency/payrolls/create`): pick a period (month). For every agent in the
   agency, pulls together: base salary (from whichever compensation plan was in effect as of
   the period's end), every `approved` commission not yet attached to a payroll (plus eligible
   reversals — see §3), and any active advance's monthly instalment. Agents with nothing owed
   are skipped entirely — not added as a zero row.
2. **Review (draft only)**: each line's bonus, other-deduction, and tax fields are editable
   inline (base salary, commission, and advance deduction are computed, not editable). Net
   payable recalculates on save.
3. **Approve**: **locks every item's figures** — no further edits to bonus/deductions after
   this point. Nothing about money movement happens yet; this is a sign-off checkpoint.
4. **Mark Paid**: the point money actually moves — every `approved` commission on the payroll
   flips to `paid` (reversal rows stay `reversed`, they were never a payout in their own
   right), and each agent's active advances are drawn down by that item's advance-deduction
   amount, oldest-issued-first, clearing (`status = cleared`) any that hit zero balance.

**Deviation from spec:** no PDF payslip generation this pass — the payroll show page is the
payslip (on-screen only). No automated tax calculation — `tax_deduct` is a manual field,
defaults to 0.

---

## 6. Advances

`/agency/advances` — Agency Admin only.

1. **Issue**: amount, monthly deduction amount, optional reason, issue date. Balance starts
   equal to the full amount.
2. **Write off**: for a debt that will never be recovered — sets `status = written_off` and
   stops it being deducted from future payroll. The record stays visible; nothing is deleted.
3. Advances clear automatically (`status = cleared`) once a payroll run's "Mark Paid" step
   brings the balance to zero — see §5.

---

## 7. Agent view — My Earnings

`/agency/my-earnings` — Agent only, read-only. Mirrors what the Agency Admin sees, scoped to
just this agent: current compensation plan, their own commission ledger, their own payroll
history (net payable per period, per-payroll status), and their own advances (amount, balance,
status).

---

## 8. Data model summary

Eight tables, all following the codebase's standing "deactivate/void, never delete" rule:
`bookings`, `payments`, `compensation_plans`, `agent_compensation`, `commissions`, `payrolls`,
`payroll_items`, `advances`. See the migrations under `database/migrations/2026_08_07_1*` for
exact columns, and `app/Services/CommissionService.php` / `app/Services/PayrollService.php`
for the accrual and payroll-generation logic respectively — both are small enough to read
end to end rather than relying on this summary for the exact formulas.
