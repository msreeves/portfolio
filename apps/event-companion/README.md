# Event Companion

Day-of schedule **companion demo** for MSR Events (hub + Awards + Seminars) — programme picker, today / on-now, saved sessions, and Register handoff to the same booking URL as WordPress.

**Local demo:** [picker](http://127.0.0.1:8888/sites/portfolio/projects/event-companion/) · [Seminars schedule](http://127.0.0.1:8888/sites/portfolio/projects/event-companion/?event=msrseminars) · [Awards stub](http://127.0.0.1:8888/sites/portfolio/projects/event-companion/?event=msrawards)

> Portfolio companion demo — static JSON feed; not a native app store build. Programme websites link out to this SPA.

## Stack

React · TypeScript · Vite · Tailwind CSS · Zod

## Quick start

```bash
git clone https://github.com/msreeves/event-companion.git
cd event-companion
npm install
npm run dev
```

Open `http://127.0.0.1:5173/` for the programme picker, `?event=msrseminars` for the Seminars schedule, or `?event=msrawards` for the Awards stub.

```bash
npm run build && npm run preview
```

Missing `?event=` → **Choose a programme** (catalog). Unknown programmes: friendly error with picker + hub events.  
Awards (`?event=msrawards`) is **stub mode** (no agenda CPT — website-led). Demo clock: outside programme dates, pins to Day 1 mid-morning (`?now=` override).

**Exit chrome (C0) + picker (C1a)**
- Sticky header + footer: **Back to website** → `site_url` (programme home)
- **All programmes** → picker (`./`)
- Optional **Hub event page** → `event_page_url`
- Feed fields (local MAMP):

| Field | Local | Production (Owner B5 / Hostinger) |
|-------|-------|-----------------------------------|
| `site_url` | `http://msrevents.local:8888/msrseminars/` | `https://www.msreeves.co.uk/events/msrseminars/` |
| `event_page_url` | `http://msrevents.local:8888/event/msrseminars/` | hub event URL on live Events |
| Catalog | `data/catalog.json` | same path under `/projects/event-companion/` |
| Unknown exit | picker + hub `/our-events/` | same paths on live |

**Features**
- Programme picker (C1a)
- Awards stub feed (C1b) — `mode: stub`
- Today / on-now / My agenda / All
- Track filter chips
- Save sessions (localStorage)
- Add to calendar (.ics) + export My agenda
- Register → shared `booking_url`
- **Back to website** (site exit — not only agenda)
- Disclaimer + unknown `?event=` → picker

## Structure

```
public/data/     catalog.json · msrseminars.json · msrawards.json (+ sample)
src/
  components/    picker, shell, session lists, register
  lib/           schema, feed, time, saved
docs/            SESSION_ID_MAP.md, DATA_FEED.md
```

## Portfolio workspace (optional)

If this folder lives inside the MSR portfolio tree (`sites/portfolio/apps/event-companion/`):

```bash
npm run ship:portfolio:local   # MAMP base → projects/event-companion/
npm run ship:portfolio         # prod Vite base /projects/event-companion/
```

Ship decisions: [`PORTFOLIO_SHIP.md`](./PORTFOLIO_SHIP.md).

## License

Private portfolio demo source — all rights reserved unless noted otherwise.
