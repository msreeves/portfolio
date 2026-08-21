# Event Companion

Day-of schedule **companion demo** for MSR Seminars — today / on-now, saved sessions, and Register handoff to the same booking URL as WordPress.

**Live demo (local MAMP):** [sites/portfolio/projects/event-companion](http://127.0.0.1:8888/sites/portfolio/projects/event-companion/?event=msrseminars)

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

Open `http://127.0.0.1:5173/?event=msrseminars` (or the URL Vite prints).

```bash
npm run build && npm run preview
```

Unknown programmes: `?event=msrawards` shows a friendly error with a link to Seminars.  
Demo clock: outside programme dates, pins to Day 1 mid-morning (`?now=` override).

**Features**
- Today / on-now / My agenda / All
- Track filter chips
- Save sessions (localStorage)
- Add to calendar (.ics) + export My agenda
- Register → shared `booking_url`
- Disclaimer + unknown `?event=`

## Structure

```
public/data/     msrseminars.json (+ sample)
src/
  components/    shell, session lists, register
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
