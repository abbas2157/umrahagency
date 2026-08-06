# PLANS & BILLING — SaaS for Umrah agencies

You are selling software to agencies, not running one. Every design decision changes.

---

## 1. Multi-tenancy first

**Do this before writing anything else.**

Every table needs an `agency_id`. Every query filters by it. A single missed filter means
one agency sees another's customers and bookings — the kind of bug that ends a B2B product.

```sql
CREATE TABLE agencies (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name          VARCHAR(120) NOT NULL,
    slug          VARCHAR(140) NOT NULL UNIQUE,
    owner_email   VARCHAR(120) NOT NULL UNIQUE,
    owner_phone   VARCHAR(20)  NOT NULL,
    city          VARCHAR(80)  NOT NULL,
    status        ENUM('trial','active','past_due','suspended','cancelled')
                  NOT NULL DEFAULT 'trial',
    trial_ends_at DATE NULL,
    created_at    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

Then add `agency_id INT UNSIGNED NOT NULL` to `branches`, `agents`, `bookings`, `payments` —
with a foreign key and an index on every one.

**Enforce the filter globally, not per query.** In Laravel use a global scope; otherwise a
base repository that every query goes through. Never rely on developers remembering to add
`WHERE agency_id = ?`. They will forget once, and once is enough.

---

## 2. Plans

Your stated plan is the middle tier. Two neighbours make it look like the sensible choice.

| | **Starter** | **Growth** | **Business** |
|---|---|---|---|
| Price / month | PKR 2,500 | **PKR 5,000** | PKR 12,000 |
| Branches | 1 | 2 | 5 |
| Agents | 3 | 10 | 25 |
| Bookings | Unlimited | Unlimited | Unlimited |
| WhatsApp receipts | ✓ | ✓ | ✓ |
| Online payment links | — | ✓ | ✓ |
| Reports | Basic | Full | Full + export |
| Support | Email | WhatsApp | Priority |

**Add-ons:** extra agent PKR 400/month, extra branch PKR 1,500/month. This is important —
an agency at 11 agents shouldn't be forced to jump to a PKR 12,000 tier. Let them grow
smoothly and you'll lose fewer of them.

**Annual: pay for 10 months, get 12.** In Pakistan this matters more than the discount
suggests — see §3.

**Trial: 14 days, no card required.** Asking for card details upfront will kill most of your
signups in this market.

### Notes on pricing

- Don't cap bookings. Charging more when an agency does well feels like a penalty, and they
  will under-report to stay under the cap.
- Agent seats are your value metric. Simple, understood, grows with their business.
- PKR 5,000/month for a 10-agent agency is roughly PKR 500 per agent. That's cheap enough
  to be an easy yes and still real revenue at scale. Don't discount it further to close
  early deals — you'll never raise it back.

---

## 3. Collecting the money

**Most of your customers will not set up card auto-debit.** Card penetration among small
Pakistani businesses is low, and business owners are wary of recurring authorisations.
Design invoice-first, treat auto-debit as a bonus.

**Primary flow — invoice and confirm:**

1. Invoice generated 7 days before the period ends
2. Sent by WhatsApp and email, with a payment link and your bank/Raast details
3. Agency pays by bank transfer, Raast, or card link
4. Payment recorded — auto-matched by gateway callback, or manually confirmed by you

**Secondary flow — auto-debit.** Gateways with card-on-file tokenisation (XPay, HBLPay,
and others) can charge a saved card each cycle. Offer it, make it optional, and never
require it.

**Raast is worth prioritising** for collection. It's instant, free for the payer, and its
Request-to-Pay flow fits subscription billing well.

**Push annual prepayment hard.** Collection is your biggest operational cost and monthly
chasing does not scale. An agency that pays once a year is a customer you never have to
chase.

---

## 4. Billing schema

```sql
CREATE TABLE plans (
    id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code          VARCHAR(30)  NOT NULL UNIQUE,   -- 'starter','growth','business'
    name          VARCHAR(60)  NOT NULL,
    price_monthly DECIMAL(10,2) NOT NULL,
    price_yearly  DECIMAL(10,2) NOT NULL,
    max_branches  SMALLINT UNSIGNED NOT NULL,
    max_agents    SMALLINT UNSIGNED NOT NULL,
    features      JSON NOT NULL,
    is_active     BOOLEAN NOT NULL DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE subscriptions (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    agency_id      INT UNSIGNED NOT NULL,
    plan_id        INT UNSIGNED NOT NULL,
    billing_cycle  ENUM('monthly','yearly') NOT NULL DEFAULT 'monthly',
    extra_agents   SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    extra_branches SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    status         ENUM('trialing','active','past_due','cancelled') NOT NULL,
    current_period_start DATE NOT NULL,
    current_period_end   DATE NOT NULL,
    cancelled_at   TIMESTAMP NULL,

    FOREIGN KEY (agency_id) REFERENCES agencies(id),
    FOREIGN KEY (plan_id)   REFERENCES plans(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE invoices (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    agency_id    INT UNSIGNED NOT NULL,
    invoice_no   VARCHAR(20)  NOT NULL UNIQUE,    -- sequential, no gaps
    period_start DATE NOT NULL,
    period_end   DATE NOT NULL,
    subtotal     DECIMAL(10,2) NOT NULL,
    tax          DECIMAL(10,2) NOT NULL DEFAULT 0,
    total        DECIMAL(10,2) NOT NULL,
    status       ENUM('draft','sent','paid','overdue','void') NOT NULL DEFAULT 'draft',
    due_date     DATE NOT NULL,
    paid_at      TIMESTAMP NULL,
    method       VARCHAR(30) NULL,                -- bank_transfer, raast, card
    reference    VARCHAR(120) NULL,

    FOREIGN KEY (agency_id) REFERENCES agencies(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

Store the plan's limits **on the subscription at purchase time** if you ever plan to change
plan pricing. Otherwise a price rise silently applies to existing customers, which is both
unfair and a support nightmare.

---

## 5. Enforcing limits

Check at the moment of creation, not on a schedule:

```
Creating agent #11 on Growth →
  "Your plan includes 10 agents. Add another for PKR 400/month, or upgrade to Business."
```

**Never delete data when someone downgrades or lapses.** Deactivate the excess and let the
agency choose which agents stay active. Deleting a customer's records over a billing
question destroys trust permanently.

---

## 6. When payment fails

Pakistani SMBs pay late routinely. It is not usually churn — it's cash flow. Design for it.

| Day | Action |
|---|---|
| 0 | Invoice due. WhatsApp reminder. |
| +3 | Second reminder, still full access. |
| +7 | Status `past_due`. Banner in the dashboard. Full access. |
| +14 | **Read-only.** They can view and export everything, but not create. |
| +30 | Suspended. Data retained. |
| +90 | Data archived. Warn before, and never delete without written notice. |

Read-only rather than lockout is deliberate. An agency locked out mid-Umrah-season, unable
to see who's flying tomorrow, becomes an angry ex-customer and tells other agencies.

---

## 7. Also plan for

**Tax.** Confirm sales tax on IT services with your accountant before issuing the first
invoice. Retrofitting tax onto issued invoices is painful and looks unprofessional.

**Onboarding.** Your customers are not technical. Someone will need to set up their branches,
agents, and packages. Budget real time for this, or build an import tool — it's the single
biggest predictor of whether they stick.

**Support in Urdu, over WhatsApp.** Email tickets will go unanswered by your customers.

**Data export.** Let agencies export their data whenever they want. It reduces the fear of
being locked in, which is a real objection when selling to cautious small businesses.

---

## 8. Build prompt

```
Task: Add multi-tenancy and the plan system. This comes before any other feature work.

  1. Migration: create `agencies` and `plans` tables
  2. Migration: add agency_id (FK + index) to branches and agents
  3. Global scope so every query is automatically filtered by the current agency —
     not a manual WHERE clause in each query
  4. Seed the three plans from the table above
  5. Limit enforcement on agent and branch creation, with the upgrade message
  6. Tests proving one agency cannot read another's branches or agents

Not in this pass: invoices, payment collection, dunning.

Follow CLAUDE.md. Show me the file plan and migrations first — no code until I approve.
```
