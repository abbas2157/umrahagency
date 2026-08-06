# AGENCY DETAILS — umrahagency.pk

Fill every field. Anything left as `[ ]` must NOT be published — ask me for it instead of
inventing a placeholder. Never write `+92-XXX-XXXXXXX`, `………`, or lorem ipsum into a live file.

---

## Identity

```
Brand name (display):        Umrah Agency Pakistan
Legal registered name:       [ e.g. XYZ Travels (Pvt) Ltd ]
Founded (year):              [ footer currently says 2020 — confirm ]
Owner / CEO name:            [ ]
Tagline (one line):          [ ]
Logo path:                   /public/assets/images/logo.png
```

## Phone & messaging

```
Primary phone (local):       0325 121 2747
Primary phone (E.164):       +923251212747
WhatsApp number (E.164, NO leading zero, NO +, NO spaces):
                             923251212747
   → wa.me link must be:     https://wa.me/923251212747
Secondary phone:             [ ]
Landline:                    [ ]
Best hours to call:          [ ]
```

## Email

```
General enquiries:           info@umrahagency.pk
Bookings:                    [ ]
Complaints / support:        [ ]
```

## Address

```
Street / building:           [ full address — "Doctor Hospital Johar Town Lahore" is
                               a landmark, not a postal address. Need shop/office no.,
                               floor, street, block. ]
Area / block:                [ e.g. Block G1, Johar Town ]
City:                        Lahore
Province:                    Punjab
Postal code:                 [ ]
Country:                     Pakistan
Google Maps share link:      [ ]
Latitude, Longitude:         [ ] , [ ]   ← needed for schema markup
Branch offices:              [ list each with full address + phone, or write "none" ]
```

## Opening hours

```
Mon–Thu:                     [ e.g. 10:00–19:00 ]
Friday:                      [ note Jummah break if applicable ]
Saturday:                    [ ]
Sunday:                      [ open / closed ]
Public holidays:             [ ]
Timezone:                    Asia/Karachi (PKT, UTC+5)
```

## Licensing & trust signals

These matter more than design on a pilgrimage site. Publish only what you actually hold.

```
Ministry of Religious Affairs Hajj/Umrah licence no.:  [ ]
DTS / Travel agency licence no.:                       [ ]
IATA accreditation no.:                                [ or "not IATA accredited" ]
NTN / tax registration:                                [ ]
Chamber / association memberships:                     [ e.g. TAAP, PATO ]
Saudi Nusuk Masar registration:                        [ if applicable ]
```

> The footer currently carries a **UK ATOL disclaimer**. ATOL is a UK Civil Aviation
> Authority scheme and does not apply to a Pakistan-based agency. Remove it and replace
> with the real licences above. Do not publish any protection claim that isn't true.

## Social profiles

```
Facebook:    https://www.facebook.com/umrahagency
Twitter/X:   https://twitter.com/umrahagency/
Instagram:   https://www.instagram.com/umrahagency/
Pinterest:   https://www.pinterest.com/umrahagency/
YouTube:     [ ]
TikTok:      [ ]
Google Business Profile: [ ]
```

## Service & operations

```
Departure airports served:   Lahore, Karachi, Islamabad, Multan, Sialkot,
                             Faisalabad, Peshawar, other Pakistan airports
                             ← the modal form wrongly lists UK airports. Use this list.
Services offered:            Hajj packages, Umrah packages, Umrah visa, flights,
                             hotels near Haram, ground transfers, guided rituals
Languages spoken:            Urdu, English, [ Punjabi? Pashto? ]
Currency:                    PKR (format: PKR 180,000 / pp)
Payment methods accepted:    [ bank transfer / cash / card / Easypaisa / JazzCash ]
Booking deposit policy:      [ ]
Refund / cancellation policy URL: /terms-conditions.html
```

---

## How to use this block

Paste it above your task, then state the task. Example:

> [paste this file]
>
> Task: Replace all placeholder contact information on contact-us.html and in the
> site footer with the real details above. Also add JSON-LD `TravelAgency` schema
> using this data. Show me the plan and the list of files first — don't write code yet.

## Rules for the agent

1. Use these values verbatim. Do not reformat the phone number, rewrite the address, or
   "improve" the business name.
2. **NAP consistency is an SEO ranking factor.** Name, Address, and Phone must appear
   byte-identical across the footer, contact page, schema markup, and Google Business
   Profile. Any variation weakens local ranking.
3. If a field is still `[ ]`, stop and ask. Never ship a placeholder.
4. Store these in ONE config file (`config/agency.php` or equivalent) and reference it
   everywhere. Do not hardcode the phone number into thirty HTML files — that is how
   the current wrong WhatsApp link ended up sitewide.
5. WhatsApp links: `https://wa.me/923251212747` — international format, no `0`, no `+`.
6. `tel:` links: `tel:+923251212747` — E.164 so it works for international callers.
