# Data feed load path (`?event=`)

**Known feeds:** `msrseminars` (schedule) · `msrawards` (stub — no agenda CPT).

## URL

| Environment | Example |
|-------------|---------|
| Local picker (C1a) | `http://127.0.0.1:8888/sites/portfolio/projects/event-companion/` |
| Local Seminars | `…/event-companion/?event=msrseminars` |
| Local Awards (C1b stub) | `…/event-companion/?event=msrawards` |
| Vite dev | `http://127.0.0.1:5173/` (picker) · `?event=msrseminars` · `?event=msrawards` |
| Production | `https://www.msreeves.co.uk/projects/event-companion/` |

Missing or empty `event` → **programme picker** (`data/catalog.json`).  
Unknown `event` (not in the allowlist) → friendly error + **link to picker** (not a hard error only).  
Deep-link `?event=msrseminars` still loads the Seminars schedule.  
`?event=msrawards` loads the Awards **stub** (`mode: stub`) — website-led, no session grid.

## Zod `mode`

| `mode` | Meaning |
|--------|---------|
| `schedule` (default) | Requires `demo_dates`, `tracks`, `sessions` (≥1 each) |
| `stub` | Empty sessions OK — Awards has **no agenda CPT**; UI is R7 empty + site exit |

## Resolution

```ts
const params = new URLSearchParams(window.location.search);
const raw = params.get("event");
if (!raw?.trim()) {
  // load data/catalog.json → ProgrammePickerView
}
const event = raw.trim().toLowerCase();
// Allowlist (JSON files):
if (event !== "msrseminars" && event !== "msrawards") throw new UnknownEventError(event);

const url = `${import.meta.env.BASE_URL}data/${event}.json`;
const feed = await fetch(url).then((r) => r.json());
```

| Piece | Path |
|-------|------|
| Catalog (C1a) | `apps/event-companion/public/data/catalog.json` |
| Seminars schedule | `apps/event-companion/public/data/msrseminars.json` |
| Awards stub (C1b) | `apps/event-companion/public/data/msrawards.json` |
| Shipped copy | `projects/event-companion/data/` (via Vite `public/`) |
| Zod parse | App `src/lib/schema.ts` / optional A5 `EventCompanionFeed` in contracts |
| REST (future) | [`REST.md`](./REST.md) — static JSON remains default |
| Comps / keep-skip | [`COMPS.md`](./COMPS.md) |

## Sync rule

When WP agenda session titles or row order change, update `msrseminars.json` and [`SESSION_ID_MAP.md`](./SESSION_ID_MAP.md) in the same slice — static v1 does not auto-export. Awards has **no** session ids until an agenda CPT exists (do not invent a ceremony grid).
