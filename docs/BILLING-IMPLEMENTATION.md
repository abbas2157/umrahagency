# BILLING IMPLEMENTATION

How billing actually runs, day to day, for agencies on the platform.

---

## 1. Lifecycle

```
signup → trialing (14 days)
              │
              ├── pays  ────────────► active ◄──────┐
              │                          │          │
              └── doesn't pay ──► cancelled         │ pays
                                                     │
                          active ──► past_due ──► read_only ──► suspended
                                       (day 7)     (day 14)      (day 30)
```

Every transition is triggered by a scheduled job, never by a user action. Store the reason
and timestamp for each change — you will be asked "why was my account locked" and you need
an answer.

Add a `subscription_events` table logging every status change, plan change, and invoice
event. When an agency disputes something six months later, this is what settles it.

---

## 2. Scheduled jobs

Four jobs, all daily. **Every one must be idempotent** — safe to run twice without creating
duplicate invoices or sending duplicate reminders. Servers restart, cron misfires, someone
reruns a job manually.

| Time | Job | What it does |
|---|---|---|
| 02:00 | `generate-invoices` | Creates invoices for subscriptions whose period ends in 7 days |
| 03:00 | `update-statuses` | Moves accounts through past_due → read_only → suspended |
| 09:00 | `send-reminders` | Due-date and overdue reminders by WhatsApp and email |
| 09:30 | `trial-reminders` | Days 7, 12, and 14 of trial |

Enforce idempotency at the database level:

```sql
ALTER TABLE invoices
  ADD UNIQUE KEY uniq_period (agency_id, period_start);
```

Now a double-run fails on insert instead of billing someone twice.

**Generation logic:**

```
for each active subscription where current_period_end = today + 7:
    subtotal = plan price (monthly or yearly)
             + extra_agents   × 400
             + extra_branches × 1500
    total    = subtotal + tax
    create invoice (status: sent, due_date: current_period_end)
    send WhatsApp + email with payment link
```

---

## 3. Taking payment

### Bank transfer and Raast — expect this to be the majority

There is no automatic confirmation. The flow is:

1. Invoice shows your bank details, Raast ID, and the invoice number as reference
2. Agency pays from their own banking app
3. Agency submits the transaction reference and a screenshot in their billing portal
4. You verify against your bank statement and confirm

Build screen 4 properly — it's a daily task for you. A queue of pending confirmations
showing agency name, amount, reference, screenshot, and one-click confirm.

**Always ask for the invoice number as the transfer reference.** Without it, matching a
PKR 5,000 credit to one of forty agencies paying the same amount is guesswork.

### Card and payment links

The gateway calls your webhook. Requirements:

- **Verify the signature** before trusting anything in the payload
- **Be idempotent** — gateways retry; a repeated callback must not mark the invoice paid
  twice or create a second payment row
- **Respond 200 quickly**, then process asynchronously. Slow webhook responses get retried,
  compounding the problem
- **Log every callback raw**, before parsing. When a payment goes missing, this is the
  only evidence you'll have

### Auto-debit

Only for agencies who explicitly opted in and have a saved card token. On failure: retry
after 3 days, then 7. After the second failure, stop retrying and switch them to invoice
flow — repeated failed attempts can get a card blocked by the issuing bank.

---

## 4. Plan changes

**Upgrade mid-cycle** — charge the difference for the days remaining:

```
days_left  = current_period_end − today
daily_diff = (new_plan_price − old_plan_price) / days_in_period
charge     = round(daily_diff × days_left)
```

Apply the new limits immediately. Issue a separate proration invoice, due now. Don't fold
it into next month's invoice — the agency upgraded because they need the seats today.

**Downgrade** — applies at period end, no refund. Say this clearly before they confirm.

If they're over the new limits at that point, don't pick which agents to deactivate. Prompt
them to choose, and hold the downgrade until they do.

**Adding seats mid-cycle** — same proration formula, and it's the most common change you'll
see. Make it two clicks.

---

## 5. Agency-facing screens

Keep it to one billing page with four sections:

**Current plan** — plan name, seats used vs included (`8 of 10 agents`), next billing date,
next amount. Buttons: change plan, add seats.

**Invoices** — list with number, period, amount, status, PDF download. Unpaid ones show a
Pay button.

**Payment submission** — for bank transfer: transaction reference field, screenshot upload,
submit. Shows pending status until you confirm.

**Payment method** — bank details and Raast ID displayed for copying; optional saved card.

That's the whole thing. Resist adding usage graphs and analytics — nobody visits a billing
page for insight.

---

## 6. Your admin screens

**Revenue dashboard** — MRR, active agencies by plan, trials ending this week, overdue total.

**Pending confirmations** — the queue from §3. This is your daily driver.

**Agency detail** — status, plan, invoice history, payment history, event log, and manual
overrides: extend trial, apply credit, waive an invoice, force status. Every override
logged with who did it and why.

**Overdue list** — sorted by days overdue, with one-click WhatsApp reminder.

---

## 7. Notifications

WhatsApp first, email as backup. Your customers read WhatsApp.

| Trigger | Message |
|---|---|
| Invoice generated | Amount, due date, payment link |
| Due today | Short reminder + link |
| +3 days | Reminder, mention access continues |
| +7 days | **Warning**: read-only in 7 days |
| +14 days | Account now read-only, how to restore |
| Payment confirmed | Receipt with invoice number |
| Trial day 7 / 12 | Days remaining, plan options |

Keep them short and in plain language. Include the invoice number in every one — it's how
the conversation stays anchored when they call you about it.

---

## 8. Rules

**Invoice numbers are sequential with no gaps.** Void, never delete. Gaps look like fraud.

**Money records are append-only.** Corrections are reversing entries, not edits.

**`DECIMAL`, never `FLOAT`.**

**Never delete agency data for non-payment.** Read-only, then suspended, then archived after
90 days with written notice. An agency mid-season needs to see tomorrow's departures even
if they haven't paid — locking that out costs you the customer and their referrals.

**Log every status change with a reason.** Support conversations depend on it.

**Test the whole cycle with a fake clock.** Advance the date in a test environment and
confirm invoices generate once, reminders fire on the right days, and statuses move
correctly. Billing bugs are discovered by customers, which is the worst way to find them.

---

## 9. Build prompt

```
Task: Build billing. Multi-tenancy and plans must already exist.

Phase 1 — invoices and manual payment:
  1. Migrations: invoices, subscription_events
     (unique key on agency_id + period_start)
  2. Daily job: generate invoices 7 days before period end — idempotent
  3. Daily job: status transitions (past_due day 7, read_only day 14,
     suspended day 30), each logged to subscription_events
  4. Agency billing page: current plan, invoice list, payment submission form
  5. Admin: pending payment confirmation queue, overdue list
  6. WhatsApp + email notifications for invoice generated, due, and overdue

Not in this pass: card auto-debit, gateway webhooks, proration.

Include tests for: invoice generated exactly once per period, status
transitions fire on the correct day, read-only blocks creation but allows reads.

Follow CLAUDE.md. Show me the file plan and migrations first — no code until I approve.
```
