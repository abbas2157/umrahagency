# SALARY & COMMISSION

Lets an agency pay its agents by salary, commission, or both. Tenant feature — every table
carries `agency_id`, and every agency sets its own rates.

---

## 1. The rule that matters most

**Commission is earned on money received, not on bookings made.**

If you calculate commission on booking value, an agent books PKR 400,000, takes a PKR 50,000
deposit, earns full commission — and then the customer cancels. The agency has paid out
against money it never collected.

So: as each payment lands against a booking, commission accrues on that payment.

```
Booking PKR 400,000, agent commission 2%  →  total earnable PKR 8,000

Deposit    PKR  50,000 received  →  PKR 1,000 accrued
Instalment PKR 150,000 received  →  PKR 3,000 accrued
Final      PKR 200,000 received  →  PKR 4,000 accrued
```

This makes cancellations self-correcting. Nothing was accrued on money that never arrived.

---

## 2. Compensation models

An agency picks one per agent:

| Model | Who it fits |
|---|---|
| **Salary only** | Visa officers, support staff, office managers |
| **Commission only** | Freelance and referral agents |
| **Salary + commission** | Most consultants — the common case |
| **Salary + target bonus** | Senior staff on monthly targets |

### How commission is calculated

Two options. Let the agency choose per plan.

**Percentage of margin** — correct, but requires the agency to record cost price per booking.
Umrah margins are thin and vary by season; a flat percentage of sale price can exceed the
actual margin on a discounted package.

**Fixed amount per booking tier** — simpler and what most agencies will actually use:

```
3-star package   →  PKR 3,000 per booking
4-star package   →  PKR 5,000 per booking
5-star package   →  PKR 8,000 per booking
Visa only        →  PKR   500 per application
```

Fixed amounts still accrue proportionally as payments come in.

**Tiered targets** stack on top:

```
0–4 bookings/month     →  base rate
5–9 bookings/month     →  base rate + 20%
10+ bookings/month     →  base rate + 40%
```

Decide upfront whether a tier upgrade applies retroactively to all bookings that month or
only to bookings past the threshold. Write it into the agent's contract — this is the single
most common commission dispute.

---

## 3. Schema

```sql
CREATE TABLE compensation_plans (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    agency_id       INT UNSIGNED NOT NULL,
    name            VARCHAR(80)  NOT NULL,        -- "Senior Consultant 2026"
    type            ENUM('salary','commission','salary_commission') NOT NULL,
    base_salary     DECIMAL(10,2) NOT NULL DEFAULT 0,
    commission_type ENUM('percent_sale','percent_margin','fixed_per_tier') NULL,
    commission_rate DECIMAL(5,2)  NULL,           -- when percent-based
    tier_rates      JSON NULL,                    -- {"3star":3000,"4star":5000,...}
    target_rules    JSON NULL,
    is_active       BOOLEAN NOT NULL DEFAULT TRUE,

    INDEX idx_agency (agency_id),
    FOREIGN KEY (agency_id) REFERENCES agencies(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE agent_compensation (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    agency_id       INT UNSIGNED NOT NULL,
    agent_id        INT UNSIGNED NOT NULL,
    plan_id         INT UNSIGNED NOT NULL,
    effective_from  DATE NOT NULL,
    effective_to    DATE NULL,                    -- NULL = current

    INDEX idx_agent (agent_id, effective_from),
    FOREIGN KEY (agent_id) REFERENCES agents(id),
    FOREIGN KEY (plan_id)  REFERENCES compensation_plans(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE commissions (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    agency_id     INT UNSIGNED NOT NULL,
    agent_id      INT UNSIGNED NOT NULL,
    booking_id    INT UNSIGNED NOT NULL,
    payment_id    INT UNSIGNED NOT NULL,          -- which payment triggered it
    amount        DECIMAL(10,2) NOT NULL,         -- negative for reversals
    share_percent DECIMAL(5,2) NOT NULL DEFAULT 100,
    status        ENUM('accrued','approved','paid','reversed') NOT NULL DEFAULT 'accrued',
    payroll_id    INT UNSIGNED NULL,              -- set when paid out
    note          VARCHAR(255) NULL,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_agent_status (agent_id, status),
    FOREIGN KEY (agent_id)   REFERENCES agents(id),
    FOREIGN KEY (booking_id) REFERENCES bookings(id),
    FOREIGN KEY (payment_id) REFERENCES payments(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

Payroll:

```sql
CREATE TABLE payrolls (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    agency_id    INT UNSIGNED NOT NULL,
    period_month DATE NOT NULL,                   -- first day of month
    status       ENUM('draft','approved','paid') NOT NULL DEFAULT 'draft',
    approved_by  INT UNSIGNED NULL,
    paid_on      DATE NULL,

    UNIQUE KEY uniq_period (agency_id, period_month)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE payroll_items (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    payroll_id     INT UNSIGNED NOT NULL,
    agent_id       INT UNSIGNED NOT NULL,
    base_salary    DECIMAL(10,2) NOT NULL DEFAULT 0,
    commission     DECIMAL(10,2) NOT NULL DEFAULT 0,
    bonus          DECIMAL(10,2) NOT NULL DEFAULT 0,
    advance_deduct DECIMAL(10,2) NOT NULL DEFAULT 0,
    other_deduct   DECIMAL(10,2) NOT NULL DEFAULT 0,
    tax_deduct     DECIMAL(10,2) NOT NULL DEFAULT 0,
    net_payable    DECIMAL(10,2) NOT NULL,
    notes          VARCHAR(255) NULL,

    UNIQUE KEY uniq_agent (payroll_id, agent_id),
    FOREIGN KEY (payroll_id) REFERENCES payrolls(id),
    FOREIGN KEY (agent_id)   REFERENCES agents(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE advances (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    agency_id     INT UNSIGNED NOT NULL,
    agent_id      INT UNSIGNED NOT NULL,
    amount        DECIMAL(10,2) NOT NULL,
    reason        VARCHAR(160) NULL,
    monthly_deduct DECIMAL(10,2) NOT NULL,        -- recovery per month
    balance       DECIMAL(10,2) NOT NULL,
    issued_on     DATE NOT NULL,
    status        ENUM('active','cleared','written_off') NOT NULL DEFAULT 'active',

    FOREIGN KEY (agent_id) REFERENCES agents(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

Advance salary is a normal request in Pakistani workplaces, especially before Eid. Build it
in — agencies will otherwise track it on paper and the payroll numbers won't reconcile.

**Never charge interest on an advance.** It's riba, and your customers are religious travel
businesses. Recover the principal in instalments, nothing more.

---

## 4. Rules

**Commission rows are append-only.** A cancelled booking creates a negative reversal row,
never a deletion. The agent's earnings history must stay auditable.

**Refund triggers a reversal.** When a payment is refunded, reverse the commission accrued
against it. If it was already paid out, carry the negative balance into next month's payroll
and tell the agent before they see it on a payslip.

**Hold before paying out.** Recommended default: commission becomes `approved` when the
booking is fully paid, and payable only after the group travels. Umrah cancellations happen
close to departure. Let each agency configure the hold rule, but default to the safe one.

**Rate changes are never retroactive.** Use `effective_from` / `effective_to` on
`agent_compensation`. Recalculating past commissions when a rate changes will cost you an
agent's trust immediately.

**Split commissions.** One agent takes the enquiry, another closes it. Support splitting by
`share_percent` across multiple rows — total must equal 100, validated server-side.

**Payslips are locked once the payroll is approved.** Corrections go into the next period as
an adjustment line. Editing a paid payslip is how disputes become impossible to settle.

**Draft, then approve, then pay.** Payroll is generated as draft, the owner reviews and
adjusts, then approves. Only approved payrolls mark commissions as `paid`.

---

## 5. Payroll run

```
1. Owner opens Payroll → selects month → Generate draft
2. For each active agent:
     base_salary     from current compensation plan
     commission      SUM of approved commissions not yet in a payroll
     advance_deduct  from active advances (capped at monthly_deduct)
     tax_deduct      per agency's own settings
     net_payable     = salary + commission + bonus − deductions
3. Owner reviews, adds bonuses, adjusts, approves
4. Payslips generated as PDF, sent by WhatsApp
5. Owner records actual payment; commissions flip to 'paid'
```

Payslip must show the commission breakdown by booking. An agent who can't see which bookings
produced their commission will not trust the number, and you'll spend the month explaining it.

---

## 6. Pakistan specifics

Confirm all of these with the agency's accountant — they vary and change. Build the fields,
let the agency configure the values.

- **Income tax withholding** on salaries above the exempt threshold
- **EOBI** contributions where the agency is registered
- **Provincial social security** (PESSI in Punjab, SESSI in Sindh)
- **Minimum wage** — warn the agency if a base salary falls below the provincial minimum
- **Cash salaries are common.** Support recording cash payouts with a signed receipt, not
  just bank transfers
- **Eid bonuses** are near-universal. Make the bonus field easy to use in the right months

Don't hardcode tax rates. Slabs change annually and you'd be shipping an update every budget.

---

## 7. Build prompt

```
Task: Build salary and commission. Agents, bookings, and payments must exist.

Phase 1 — accrual and payroll, no advanced features:
  1. Migrations: compensation_plans, agent_compensation, commissions,
     payrolls, payroll_items, advances — all with agency_id
  2. When a payment is confirmed, accrue commission for the booking's agent
     using their compensation plan effective on the booking date
  3. When a payment is refunded, create a negative reversal row
  4. Payroll: generate draft for a month, review screen, approve, mark paid
  5. Payslip PDF showing salary, commission broken down by booking,
     deductions, net payable
  6. Agent view: my earnings this month, accrued vs approved vs paid

Not in this pass: tiered targets, split commissions, tax calculation.

Rules to enforce:
  - commissions table is append-only; reversals are negative rows
  - approved payrolls cannot be edited
  - commission accrues on payments received, never on booking value

Follow CLAUDE.md. Show me the file plan and migrations first — no code until I approve.
```
