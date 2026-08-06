# BRANCHES — umrahagency.pk

Physical offices where customers are served. One branch has many agents.

---

## Table

```sql
CREATE TABLE branches (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(120)  NOT NULL,      -- "Lahore — Johar Town"
    address     VARCHAR(255)  NOT NULL,
    city        VARCHAR(80)   NOT NULL,
    latitude    DECIMAL(10,8) NULL,
    longitude   DECIMAL(11,8) NULL,
    phone       VARCHAR(20)   NOT NULL,      -- +923251212747
    whatsapp    VARCHAR(20)   NOT NULL,      -- 923251212747
    email       VARCHAR(120)  NOT NULL,
    hours       VARCHAR(160)  NULL,          -- "Mon–Sat 10am–7pm"
    is_active   BOOLEAN       NOT NULL DEFAULT TRUE,
    created_at  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## Fields

| Field | Notes |
|---|---|
| `name` | Public label, usually city + area |
| `address` | Full street address — office number, floor, street, block |
| `latitude` / `longitude` | From Google Maps. Powers the map embed and local SEO |
| `phone` | E.164 with `+`, used for `tel:` links |
| `whatsapp` | Digits only, no `+`, no leading `0` |
| `hours` | Plain text. Mention the Jummah break if it applies |
| `is_active` | Deactivate instead of deleting |

---

## Rules

**Phone formats:**

| Link | Format | Example |
|---|---|---|
| `tel:` | E.164 with `+` | `tel:+923251212747` |
| `wa.me/` | digits only | `wa.me/923251212747` |

**Never delete a branch.** Set `is_active = false`. Its agents and past enquiries still
reference it.

**Block deactivating a branch with active agents.** Show how many need reassigning first.

**One source of truth.** Read contact details from this table everywhere — footer, contact
page, header. Don't hardcode them into individual pages.

---

## Build prompt

```
Task: Build the Branch module from the schema above.

  1. Migration
  2. Model with an active() scope and a hasMany relationship to agents
  3. Admin CRUD: list, create, edit, deactivate
  4. Server-side validation:
     - whatsapp: digits only, 11–15 chars, no leading zero
     - phone: E.164 format
     - cannot deactivate a branch with active agents
  5. Seed the Lahore office

Not in this pass: public branch pages, map embed, schema markup.

Follow CLAUDE.md. Show me the file plan and migration first — no code until I approve.
```
