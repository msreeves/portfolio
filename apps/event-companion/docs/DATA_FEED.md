# Data feed load path (`?event=`)

**v1 event:** `msrseminars` only.

## URL

| Environment | Example |
|-------------|---------|
| Local (after B1 ship) | `http://127.0.0.1:8888/sites/portfolio/projects/event-companion/?event=msrseminars` |
| Vite dev (A2+) | `http://127.0.0.1:5173/?event=msrseminars` |
| Production | `https://www.msreeves.co.uk/projects/event-companion/?event=msrseminars` |

Missing or empty `event` → default **`msrseminars`** (A2).  
Unknown `event` (e.g. `msrawards` before stretch) → friendly error UI (A2); do not fetch a missing file silently.

## Resolution (A2 implements)

```ts
const params = new URLSearchParams(window.location.search);
const event = (params.get("event") || "msrseminars").toLowerCase();
// Allowlist v1:
if (event !== "msrseminars") throw new UnknownEventError(event);

const url = `${import.meta.env.BASE_URL}data/${event}.json`;
// → public/data/msrseminars.json (dev)
// → /projects/event-companion/data/msrseminars.json (prod base)
const feed = await fetch(url).then((r) => r.json());
```

| Piece | Path |
|-------|------|
| Static file | `apps/event-companion/public/data/{event}.json` |
| Shipped copy | `projects/event-companion/data/{event}.json` (via Vite `public/`) |
| Zod parse | App `src/lib/schema.ts` / optional A5 `EventCompanionFeed` in contracts |
| REST (future) | [`REST.md`](./REST.md) — static JSON remains default |
| Comps / keep-skip | [`COMPS.md`](./COMPS.md) |

## Sync rule

When WP agenda session titles or row order change, update `msrseminars.json` and [`SESSION_ID_MAP.md`](./SESSION_ID_MAP.md) in the same slice — static v1 does not auto-export.
