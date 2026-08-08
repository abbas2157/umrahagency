# CLAUDE.md — umrahagency.pk

Agent operating instructions for this repository. Read fully before making any change.

---

## 0. Fill this in before first use

I inferred the stack from the live site. Correct anything wrong here — everything below depends on it.

```
Backend:            [ PHP / Laravel / CodeIgniter / static HTML — CONFIRM ]
PHP version:        [ e.g. 8.2 ]
Templating:         [ Blade / plain PHP includes / none ]
CSS:                [ Bootstrap 4 or 5? custom? — CONFIRM version ]
JS:                 [ jQuery version? vanilla? ]
Build step:         [ none / gulp / vite / webpack ]
Database:           [ MySQL? or are packages hardcoded in HTML? ]
Hosting:            [ shared cPanel / VPS / other ]
Form handler:       [ where do enquiry submissions actually go? ]
Deploy method:      [ FTP / git pull / CI ]
```

### What the site looks like from outside

- Static `.html` URLs (`/umrah-packages.html`, `/umrah/3-star-7-nights-umrah-package.html`)
- Assets under `/public/assets/` — suggests a framework with a `public/` web root, or a copied structure
- Asset folder named `haditours-imgs-updated` — the site is built on a rebranded third-party template
- Two separate enquiry forms: an inline hero form and a modal popup form
- WhatsApp and `tel:` links throughout
- Package cards are repeated with identical markup across 3-star / 4-star / 5-star sections

---

## 1. Project context

Hajj and Umrah travel agency based in Lahore, serving Pakistani pilgrims. The site's single job is **lead generation** — every page funnels toward an enquiry form, a phone call, or WhatsApp.

**Business reality that must shape technical decisions:**

- Users are largely on **mobile, on Pakistani 3G/4G, often on cheap Android devices**. Page weight is a revenue issue, not a vanity metric.
- Many users are **older and less technically confident**. Forms must be forgiving. Never punish a user for entering `0325 121 2747` instead of `03251212747`.
- Content is **Urdu-adjacent English**. Do not rewrite the agency's copy into Western marketing voice unless asked.
- Prices are in **PKR** and change with exchange rates and season. Never hardcode a price in a template if it can come from data.
- **SEO is the primary acquisition channel.** Existing URLs, meta tags, and heading structure are load-bearing. Changing a URL without a 301 destroys ranking that took years to build.
- The subject matter is **religious pilgrimage**. Tone stays respectful. Never use urgency-manipulation patterns (fake countdown timers, "only 2 seats left" when untrue) on this site.

---

## 2. Code style

**The rule that overrides everything in this section: match the file you're editing.** If existing code uses 4-space indent and `snake_case`, you use 4-space indent and `snake_case` — even if you'd prefer otherwise. Consistency inside a file beats correctness in the abstract.

Before writing anything, open 2–3 neighbouring files and copy their conventions: indentation, quote style, naming, where braces go, how much whitespace sits between blocks.

### Naming

- Descriptive over clever. `calculatePackageTotal()` not `calcPT()` and not `computePackagePriceTotalWithTaxes()`.
- Booleans read as questions: `isAvailable`, `hasVisa`, `needsTransfer`.
- No Hungarian notation, no `_tmp`, no `data2`.

### Comments

Write comments a tired colleague would thank you for at 2am.

**Do not write:**
```php
// Loop through packages
foreach ($packages as $package) {
```

**Do write:**
```php
// Saudi visa fees are quoted in SAR but charged to the customer in PKR,
// so this uses the rate locked at booking time, not today's rate.
$visaFee = $package->visa_sar * $booking->locked_rate;
```

Comment the **why**. The code already says the what.

### Functions

- One job per function. If you're writing "and" in the function name, split it.
- Guard clauses over nested `if`. Return early.
- Long is fine if it's genuinely linear. Don't chop a readable 60-line function into six 10-line functions that each get called once — that makes it harder to follow, not easier.

### Error handling

Only where failure is realistic.

- **Wrap:** database queries, form submissions, file uploads, any external API, email sending.
- **Don't wrap:** array access on data you just created, string concatenation, arithmetic on validated input.
- Never `catch (Exception $e) {}` silently. Either handle it, log it, or let it bubble.
- Users see a plain-language message. Stack traces go to logs, never to the browser in production.

### Abstraction

**Wait for the third repetition.** Two similar blocks are a coincidence; three is a pattern. Premature abstraction on a site this size costs more than the duplication it removes.

Exception: package card markup is already repeated a dozen-plus times across the homepage. That has earned a partial/component.

---

## 3. Architecture rules

### Separation

- **Templates** render. No database queries, no business logic, no price calculation inside a view.
- **Logic** lives in classes/functions, not inline in page files.
- **Data** — package details, prices, hotel names, durations — belongs in one place. Right now it appears to be duplicated across static HTML pages, which means a price change requires editing many files and guarantees they drift out of sync. If asked to touch pricing, propose consolidating first.

### Directory expectations

```
public/              # web root — only entry point + assets
  assets/
    css/
    js/
    images/
    media/
src/ or app/         # PHP classes, business logic
views/ or templates/ # markup
config/              # env-dependent settings, never committed with secrets
```

If the real structure differs, follow the real structure. Don't reorganise a working site unasked.

### Forms

Both enquiry forms are the revenue path. Rules:

- **Validate server-side. Always.** Client-side validation is a courtesy to the user, not a security measure.
- Sanitise every input before it touches a database or an email body.
- CSRF token on every POST.
- Rate-limit submissions — travel enquiry forms attract spam bots heavily.
- Normalise phone numbers on the server. Accept `0325-121-2747`, `+92 325 1212747`, `03251212747`. Store one canonical format.
- If email delivery fails, the lead must still be persisted. **Never lose a lead because SMTP timed out.**
- Honeypot field over CAPTCHA where possible — CAPTCHAs cost conversions.

### SEO — treat as protected

- Never change an existing URL without a 301 redirect.
- Never remove or alter `<title>`, meta description, canonical, or Open Graph tags as a side effect of another change. If a change requires touching them, flag it explicitly.
- One `<h1>` per page. Preserve the existing heading hierarchy.
- All images need `alt` text. Package images should describe the package.
- Keep `.webp` — don't regress images to PNG/JPG.

### Performance

- Lazy-load images below the fold.
- Serve responsive image sizes; don't ship a 1600px banner to a 360px phone.
- Defer non-critical JS.
- Question every new dependency. A 90KB library to do one thing jQuery already does is a bad trade on a Pakistani mobile connection.

### Security

- No secrets in the repo. Ever. Database credentials, SMTP passwords, and API keys go in environment config that is gitignored.
- Prepared statements only. String-concatenated SQL is an automatic reject.
- Escape on output (`htmlspecialchars` / Blade `{{ }}`) — assume all stored data is hostile.
- Force HTTPS.

---

## 4. Working protocol

### Always plan first

For anything beyond a one-line fix, respond with a plan and stop:

```
FILES TO CHANGE
  path/to/file.php    — what changes and why
  path/to/other.html  — what changes and why

NEW FILES
  path/to/new.php     — its single responsibility

APPROACH
  2–4 sentences on the strategy

RISKS
  What could break. What I'm unsure about.
  Anything touching URLs, meta tags, forms, or prices — name it here.

QUESTIONS
  Anything I had to guess at
```

Then wait. Do not write code until the plan is approved.

### Ask, don't assume

If a requirement is ambiguous, ask. A wrong assumption that reaches production on a lead-generation site costs real bookings. Specifically, always ask before:

- changing or deleting a URL
- modifying anything in `<head>`
- altering form field names (they may map to a CRM or email template)
- changing prices or package contents
- adding a dependency

### Scope discipline

Do exactly what was asked. If you spot an unrelated problem, **mention it, don't fix it**. A pull request that fixes one bug is reviewable. One that also reformats three files and renames a function is not.

### Before declaring done

- [ ] Does it work on a 360px viewport?
- [ ] Tested on mobile Chrome and Safari, not just desktop
- [ ] No console errors
- [ ] Forms still submit and the lead still arrives
- [ ] Meta tags unchanged (or changes flagged)
- [ ] No URLs changed without redirects
- [ ] No secrets committed
- [ ] Prices display correctly formatted in PKR
- [ ] `tel:` and WhatsApp links tested on an actual phone

---

## 5. Do not do these

- Don't rewrite working code to a preferred style. Working code that's ugly beats broken code that's elegant.
- Don't introduce a framework or build step into a static site without explicit approval.
- Don't add analytics, tracking pixels, or third-party scripts unasked.
- Don't generate placeholder content that could go live. No `+92-XXX-XXXXXXX`, no lorem ipsum, no `………………….` If real content is missing, ask for it or leave a `<!-- TODO: -->` that is impossible to miss.
- Don't copy legal or compliance text from other travel sites. It may not apply in this jurisdiction. (The current footer carries a UK ATOL disclaimer — see known issues.)
- Don't add `!important` to CSS. Fix the specificity.
- Don't leave `console.log` or `var_dump` in committed code.
- Don't create a `utils` or `helpers` dumping ground.
- Don't write a README, changelog, or docs unless asked.

---

## 6. Known issues

Verify each against the actual codebase before acting. Found by reading the live homepage.

| # | Issue | Impact |
|---|---|---|
| 1 | WhatsApp links use `wa.me/03251212747`. `wa.me` needs international format with no leading zero → `wa.me/923251212747` | **Every WhatsApp lead is lost.** Highest priority. |
| 2 | Modal enquiry form lists UK departure airports (Aberdeen, Heathrow, Manchester, Dublin) while the hero form correctly lists Pakistani cities | Users can't select their real airport; leads arrive with wrong data |
| 3 | Footer carries a UK CAA **ATOL** disclaimer. ATOL does not cover a Pakistan-based agency | Legal and trust risk — claiming financial protection that doesn't exist |
| 4 | Contact section shows literal placeholders: `+92-XXX-XXXXXXX` and `Office Locations: ………………….` | Looks unfinished; kills trust at the point of conversion |
| 5 | "3 Star 7 Nights" card's *View Details* links to `3-star-10-nights-umrah-package.html` | Wrong page, wrong price shown to the user |
| 6 | Package data (prices, hotels, nights) hardcoded across many HTML files | Every price update risks inconsistency between pages |
| 7 | `meta-keywords` is empty; Twitter card is `summary` rather than `summary_large_image` | Minor SEO/social presentation loss |
| 8 | Duplicated package-card markup across all three star tiers | A layout fix must be applied a dozen-plus times |

Fix order: **1 → 4 → 3 → 5 → 2**, then the rest.

---

## 7. Common tasks

**Adding a package**
Add data in one place. Reuse the existing card partial. Set meta tags, canonical, alt text. Add to the sitemap. Verify PKR formatting.

**Changing a price**
Find every occurrence — currently prices live in multiple files. Update all. Search the whole repo for the old number to confirm none were missed.

**Editing a form**
Change client and server validation together. Confirm field names still match whatever consumes them. Submit a real test lead and confirm it arrives before calling it done.

**Fixing layout**
Mobile first. Check 360px, 768px, 1440px. Because card markup is duplicated, verify the fix applied everywhere.

---

## 8. Admin panel conventions (added once the roles/CRM system landed)

The `/admin` panel has grown past a single flat inquiries list into a
role-based system (Super Admin / Agency Admin / Agent) with agencies,
users, and a real audit trail. Two conventions to keep it that way:

**Every new mutating admin action must log to `ActivityLog`.** Any
controller action that creates, updates, deletes, or otherwise changes
something security- or trust-relevant (not just inquiry status changes,
which already have their own `InquiryActivity` timeline) should call
`ActivityLog::record($action, $description, $agencyId, $subjectType, $subjectId)`
at the point the thing happens — see `AgencyController`, `UserController`,
and `AdminAuthController` for the existing pattern. `$agencyId` should be
the **affected subject's** agency (not necessarily the actor's) so an
Agency Admin can see what happened to their own agency and their own
agents, even when Super Admin made the change. Forgetting this for a new
feature means it's invisible on the Activity Log screen — "track
everything" is a standing requirement, not a one-time task.

**New sidebar items go under the right heading, not bolted onto the
end.** `resources/views/layouts/admin.blade.php` groups nav links under
`Overview` / `Queries` / `Agency Management` (super_admin only) /
`Monitoring & Security` (super_admin + agency_admin). A new mutating
feature (packages, bookings, billing) belongs under Queries or a new
heading of its own; a new read-only/audit feature belongs under
Monitoring & Security.

## 9. Response format

- No preamble. No "Great question!" No summary of what I just asked for.
- Code in fenced blocks with the file path above it.
- After a change: what changed, why, what to test. Three or four lines.
- If you were uncertain about something, say so — don't bury a guess in working-looking code.
- If you didn't do part of the request, say which part and why.
