# AGENTS — umrahagency.pk

Staff consultants who handle customer enquiries (Hajj, Umrah, visa, flights).
Every agent belongs to one branch, so build `branches` first.

---

## Table

```sql
CREATE TABLE agents (
    id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    branch_id      INT UNSIGNED NOT NULL,
    name           VARCHAR(100) NOT NULL,
    designation    VARCHAR(80)  NOT NULL,    -- "Umrah Consultant"
    phone          VARCHAR(20)  NULL,        -- +923251212747
    whatsapp       VARCHAR(20)  NOT NULL,    -- 923251212747
    email          VARCHAR(120) NOT NULL UNIQUE,
    languages      VARCHAR(160) NULL,        -- "Urdu, English, Punjabi"
    specialization VARCHAR(160) NULL,        -- "Hajj, Umrah, Visa"
    photo          VARCHAR(255) NULL,
    is_active      BOOLEAN      NOT NULL DEFAULT TRUE,
    created_at     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at     TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_branch (branch_id),
    FOREIGN KEY (branch_id) REFERENCES branches(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## Fields

| Field | Notes |
|---|---|
| `name` | Public display name |
| `designation` | Job title shown on the site |
| `phone` | E.164 with `+`, for `tel:` links |
| `whatsapp` | Digits only, no `+`, no leading `0` |
| `languages` | Comma-separated. Move to JSON only when you need to filter in SQL |
| `specialization` | Used later to route enquiries to the right person |
| `photo` | `.webp`, roughly 400×400 |
| `is_active` | Deactivate instead of deleting |

---

## Rules

**Never delete an agent.** Set `is_active = false`. Past enquiries still point to them.

**Only active agents receive new enquiries.**

**Every enquiry gets an owner.** If no agent matches, assign it to the branch manager and
flag it for manual review. An unassigned enquiry is a lost booking.

**Don't store CNIC or personal mobile numbers.** You don't need them for this, and storing
personal data you don't need creates a liability.

**Photos need consent** before they appear on the public site.

---

## Build prompt

```
Task: Build the Agent module from the schema above.

  1. Migration (branches must exist first — FK)
  2. Model with a belongsTo branch relationship and an active() scope
  3. Admin CRUD: list filtered by branch, create, edit, deactivate
  4. Server-side validation:
     - whatsapp: digits only, 11–15 chars, no leading zero
     - phone: E.164 format
     - email unique
     - branch_id must exist and be active
  5. Seed 2 sample agents for the Lahore office

Not in this pass: enquiry routing, public agent pages, performance stats.

Follow CLAUDE.md. Show me the file plan and migration first — no code until I approve.
```
