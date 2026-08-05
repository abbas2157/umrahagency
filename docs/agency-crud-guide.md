# Agency Management — Full CRUD Guide

Covers the complete lifecycle of an Agency record in the admin panel: create, view, update, deactivate ("block"), and reactivate. All steps below were verified against the running app (both automated tests and real HTTP requests) — nothing here is aspirational.

**Access:** Agencies management is Super-Admin-only. Log in at `/admin/login`, then use **Agencies** in the sidebar (not visible to Agency Admin/Agent roles).

---

## 1. Create an Agency

1. Go to **Agencies** → **Add Agency** (`/admin/agencies/create`).
2. Fill in **Brand name** and **Slug** — these are the only two required fields. The slug auto-fills from the name as you type (you can still edit it manually).
3. Optionally fill in any of the business-profile sections — none of them are required, so a record can be created with just a name and completed later:
   - **Identity** — legal name, founded year, owner/CEO name, tagline, logo path
   - **Phone & Messaging** — local/E.164 phone, WhatsApp number, secondary phone, landline, best hours to call
   - **Email** — general enquiries, bookings, complaints/support
   - **Address** — street, area, city, province, postal code, country, Google Maps link, latitude/longitude, branch offices
   - **Opening Hours** — Mon–Thu, Friday, Saturday, Sunday, public holidays, timezone
   - **Licensing & Trust Signals** — MoRA licence no., DTS licence no., IATA no., NTN, memberships, Nusuk registration
   - **Social Profiles** — Facebook, Twitter/X, Instagram, Pinterest, YouTube, TikTok, Google Business Profile
   - **Service & Operations** — departure airports, services offered, languages spoken, currency, payment methods, deposit policy, refund policy URL
4. Leave **Active** checked (default) unless you intend to create it pre-blocked.
5. Click **Create Agency**.

**Validation notes:**
- Slug must be unique and URL-safe (`alpha_dash`) — the form will show an error and preserve your other input if it collides.
- Email fields are validated as real email addresses; social/maps fields as real URLs; latitude/longitude as numeric ranges (-90..90 / -180..180).

---

## 2. View Agencies

Go to **Agencies** (`/admin/agencies`). The list shows name, slug, user count, query count, and Active/Inactive status, with pagination. There's no separate "show" page — **Edit** is also the detail view.

---

## 3. Update Agency Information

1. From the Agencies list, click **Edit** next to the agency.
2. All fields from creation are editable, pre-filled with current values, in the same section layout.
3. Change whatever's needed and click **Save Changes**.

Same validation rules as creation apply. Updating **never** touches the agency's users or queries — it only changes the agency record itself.

---

## 4. Deactivate an Agency ("Block")

Deactivating is a **suspend**, not a delete — no data is removed. Uncheck **Active** on the Edit screen and save. This is the only way to deactivate; there is no separate "delete agency" action by design (users/queries belonging to it would be orphaned or need reassignment first, so a hard delete isn't offered).

**What actually happens the moment an agency is deactivated** (all of the following are enforced in code and covered by automated tests, not just documented intent):

| Effect | Detail |
|---|---|
| **New logins blocked** | Any Agency Admin or Agent belonging to that agency gets rejected at `/admin/login` with "Your agency has been deactivated. Contact the platform administrator." |
| **Active sessions bounced immediately** | If a user from that agency is already logged in, their *very next request* logs them out and redirects to login with the same message — deactivation doesn't wait for their session to expire. |
| **No new queries can be assigned to it** | Super Admin's assign-to-agency action rejects an inactive agency's ID, even via a direct/crafted request — not just hidden from the dropdown. |
| **Existing data is untouched** | Queries already assigned to the agency, and its user accounts, remain exactly as they were — nothing is deleted or reassigned automatically. |
| **Super Admin is never affected** | Super Admin has no `agency_id` and is exempt from every check above — this only ever blocks Agency Admin/Agent accounts tied to the deactivated agency. |
| **Other agencies are unaffected** | Deactivating one agency has zero effect on any other agency's users or queries. |

---

## 5. Reactivate an Agency

1. Go to **Edit** for the agency.
2. Check **Active** again and save.
3. Effective immediately — its Agency Admin/Agent users can log in again on their next attempt, and it becomes selectable again in the assign-to-agency dropdown.

---

## Where this is enforced (for reference)

- `app/Http/Controllers/Auth/AdminAuthController.php` — blocks login at the point of authentication
- `app/Http/Middleware/EnsureAgencyIsActive.php` — bounces an existing session on its next request
- `app/Http/Controllers/Admin/InquiryController.php` (`assignAgency`) — rejects assignment to an inactive agency
- `tests/Feature/AgencyActiveStatusTest.php` — automated regression coverage for all of the above
