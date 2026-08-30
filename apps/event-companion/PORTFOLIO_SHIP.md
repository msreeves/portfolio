# Portfolio ship — MSR Event Companion (Phase A0 locked)

**Status:** A0–B5 + A3b/A4 + Track C C0–C1d complete · **UI** dark-prestige multi-programme theme · optional **A5**
**Playbook:** [`docs/plans/msr-event-companion-playbook.md`](../../../../docs/plans/msr-event-companion-playbook.md)  
**STATUS:** [`docs/plan-status.md`](../../../../docs/plan-status.md) § MSR Event Companion

Do not re-litigate A0 defaults without an explicit owner change.

---

## Why this exists

Companion **React demo** extends MSR Events programme sites — **does not replace** WordPress multisite CMS, SEO, or admin. Live event websites **link out** to the shipped SPA (CTAs + copy). Booking stays on web; the app handles day-of schedule UX.

---

## A0 defaults (locked)

| Decision | Locked value |
|----------|--------------|
| **Site model** | Link-out CTAs + copy — **not** embedded iframe / theme route |
| **Copy register** | Always **companion demo** — never “Download now” / App Store badges |
| **App model** | **One SPA**; v1 **Seminars first**; **Track C1** = multi-programme same app |
| **Exit chrome** | **Track C0** — persistent Back to website (`site_url` / `event_page_url`); not Register/agenda alone |
| **Portfolio placement** | Programme suite **Companion demo** CTAs on **Events hub** (picker) + Awards + Seminars — not Archive. Card JSON `hub: false`, `archive: false`. **Atlas Ops stays featured lead.** |
| **Slug** | `event-companion` |
| **Stack** | React, TypeScript, Vite, Tailwind, **Zod**; TanStack Query + Zustand optional |
| **`companion_demo_url` (local)** | `http://127.0.0.1:8888/sites/portfolio/projects/event-companion/?event=msrseminars` |
| **`companion_demo_url` (prod)** | `https://www.msreeves.co.uk/projects/event-companion/?event=msrseminars` (Owner **B5**) |
| **`booking_url` v1** | Demo URL (mailto / `#` + disclaimer). Future Woo on `msrproducts` — document only |
| **ACF home** | `companion_demo_url` + `booking_url` on **hub blog 1 `event` post** for slug `msrseminars` |
| **Session IDs** | JSON `sessions[].id` = agenda anchors `seminars-session-{agenda_post_id}-{row_index}` (see seed README) |
| **Timezone / demo date** | `Europe/London`; agenda seed days **2026-06-18** / **2026-06-19** (align “on now” demos to these) |
| **Vite `base` (prod)** | `/projects/event-companion/` |
| **Local ship override** | `EVENT_COMPANION_BASE=/sites/portfolio/projects/event-companion/` (mirror Atlas Ops `ATLAS_OPS_BASE`) |

---

## Brand / copy (portfolio)

| Field | Value |
|-------|--------|
| **Title** | Event Companion |
| **Stack line** | React, TypeScript, Vite, Tailwind, Zod |
| **Summary** | Day-of schedule companion for MSR Seminars — today / on-now, saved sessions, and Register handoff to the same booking URL as WordPress. |
| **CTA label (WP + portfolio)** | Open companion demo / Companion demo |

---


## Visual system (estate aligned)

| Surface | Treatment |
|---------|-----------|
| Shell | Dark prestige (`#0f0f0f` / `#1a1a1a`) — matches hub / Awards / Seminars WP themes |
| Display type | Playfair Display + DM Sans |
| Accents | Hub picker **blue** `#0E4C92` · Seminars **teal** `#2AAA8A` · Awards **gold** `#c9a84c` via `data-programme` |
| Meta | `msr-companion-theme=dark-prestige` |

## Hostinger ship (B5)

1. From `apps/event-companion`: `npm run ship:portfolio` — Vite `base` `/projects/event-companion/` **and** rewrites `data/*.json` via `config/programme-urls.json` (blocks leftover `127.0.0.1` / `.local`).
2. Root: `npm run ship -- portfolio`.
3. On Events Hostinger: set ACF / options `companion_demo_url` to prod locks (`optionLocks.companionSeminars` / `companionAwards` / `companionPicker`) — local seed URLs must not stay live.
4. Confirm `npm run url:lock:live` companion targets + picker/schedule/stub 200.
5. Restore local MAMP demo: `npm run ship:portfolio:local`.

## Paths & naming

| Role | Path / name |
|------|-------------|
| **Slug** | `event-companion` |
| **Source (dev)** | `sites/portfolio/apps/event-companion/` |
| **Shipped demo** | `sites/portfolio/projects/event-companion/` |
| **JSON feed (v1)** | `sites/portfolio/apps/event-companion/public/data/msrseminars.json` (A1) |
| **JSON sample (A0)** | `public/data/msrseminars.sample.json` |
| **Session id map** | `docs/SESSION_ID_MAP.md` |
| **Local URL** | `http://127.0.0.1:8888/sites/portfolio/projects/event-companion/?event=msrseminars` |
| **Optional public GitHub** | `https://github.com/msreeves/event-companion` (Track B4) |

---

## Theme vs URL ownership (acknowledged)

Event posts live on **hub (blog 1)**; programme subsites are blogs 2–3. CTAs must land on the **correct theme**:

| URL | Theme | Phase |
|-----|-------|-------|
| `/event/msrseminars/` | **msrevents** (hub) | **A3-hub** — required |
| `/msrseminars/` home | **msrseminars** | **A3-seminars** |
| `/msrseminars/agenda/` | **msrseminars** | A3-seminars (optional link) |
| `/msrseminars/for-delegates/` | **msrseminars** | A3-seminars (optional one line) |
| `/event/msrawards/` | msrevents | **None v1** |
| `/for-planners/` (hub) | msrevents | Optional — defer if tight |

**Mitigation:** Store URLs on hub `event` post ACF; seminars theme reads the same meta — **do not** duplicate conflicting URLs per blog.

---

## WP field placement (hub `event` post)

| Field | Location | Consumers |
|-------|----------|-----------|
| `companion_demo_url` | ACF on hub **`event`** post (`msrseminars`) | Hub event single CTA; seminars home band / agenda link; app Register target context |
| `booking_url` | Same post | WP “Register” CTAs + app **Register** button — **same value** |
| `event_type` | Existing hub field | `seminars` (v1); awards stretch later |

Seminars options may **override** only if documented in the A3-seminars seed README; default = hub meta is source of truth.

---

## Two-repo note

| Remote | What lives there |
|--------|------------------|
| [`msreeves/portfolio`](https://github.com/msreeves/portfolio) | App source under `apps/event-companion/`; shipped static under `projects/event-companion/`; card JSON |
| [`msreeves/msr-workspace`](https://github.com/msreeves/msr-workspace) (umbrella) | Playbook, STATUS, seeds, acceptance configs, theme bridge scripts |
| Optional [`msreeves/event-companion`](https://github.com/msreeves/event-companion) | Public mirror of app source (B4) — packaging only, not a second product |

**Mirror automation:** portfolio workflow `.github/workflows/mirror-event-companion.yml` copies `apps/event-companion/` → `msreeves/event-companion` on push to `main`. Secret: `EVENT_COMPANION_PUSH_TOKEN`. Local: `npm run github:hooks:install` + commit/push portfolio.

Ship scripts write into `sites/portfolio/projects/` (portfolio tree). Theme ACF/seeds live in Events multisite remotes / umbrella scripts — see [`docs/repos.md`](../../../../docs/repos.md).

---

## Sites directory (after B1 ship)

One **Companion demo** subsite link on the existing **MSR Events** row (`localhost/site-hub.custom.json` + `append_subsites`) — **not** a new hub card and **not** a Portfolio mini-site card (`hub: false`).

---

## Phase checklist (Track A → B)

### Track A

- [x] **A0** — This file + sample JSON + session-id map stub + theme/URL + two-repo
- [x] **A1** — `msrseminars.json` (7 sessions / 5 tracks); live agenda ids; `docs/DATA_FEED.md` `?event=` path
- [x] **A2** — Vite app: Zod parse, today/on-now, my agenda, lifecycle shell, Register, disclaimer, unknown `?event=`
- [x] **A3-seminars** — Home band (registration only); agenda / for-delegates; seed; acceptance v20
- [x] **A3-hub** — Event single CTA + ACF + editorial; hub acceptance v20; `verify` PASS
- [x] **Track A pre-flight (partial)** — CTAs → shipped demo HTTP 200
- [x] **A3b / A4** — ICS + track filter + REST doc (`docs/COMPS.md`); A5 deferred
- [ ] **A5** — optional shared Zod contract

### Track B

- [x] **B0** — Placement confirmed (`hub: false`, `archive: true` at B2; Atlas Ops featured)
- [x] **B1** — `ship:portfolio:local` → `projects/event-companion/` + SPA `.htaccess` + `edit-verify-map`
- [x] **B2** — `event-companion.json` + Sites Events row + Seminars programme Companion demo CTA
- [x] **B3** — Portfolio acceptance v15 · **`review:site -- portfolio` Owner if hook blocked**
- [x] **B4** — Public [`msreeves/event-companion`](https://github.com/msreeves/event-companion)
- [x] **B5** — Owner Hostinger portfolio ship + prod feeds/CTAs (**PASS 2026-08-26**)

### Track C (C0–C1b done)

- [x] **C0** — Back to website chrome + feed URLs
- [x] **C1a** — Programme picker
- [x] **C1b** — Awards stub feed (`mode: stub`; no agenda CPT)
- [ ] **C1c–d** — WP ads → hub all-events

---

## Explicitly out of scope (until STATUS unlock)

Native App Store builds · Embedded companion in WP · Push / auth / live REST (except A4 doc) · In-app payment · Second featured portfolio case study (Atlas Ops lead) · Second companion codebase per programme

---

## Risks pointer

Before each phase, re-read playbook § **Risks, issues, and mitigations** (wrong theme, URL drift, session id mismatch, `delegate_phase` drift, Vite `base`, SPA `.htaccess`).
