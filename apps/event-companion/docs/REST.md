# REST-ready notes (Phase A4 — optional)

**Status:** Documented only. The companion **defaults to static JSON** (`public/data/{event}.json` via `?event=`).

## Why static for v1

Portfolio demo — no auth, no live booking backend, no Hostinger API keys. Static feed keeps ship simple and offline-friendly (addresses a common complaint of heavy native event apps that fail on venue Wi‑Fi).

## Future REST shape (not implemented)

| Concern | Suggestion |
|---------|------------|
| List sessions | `GET /wp-json/msr/v1/companion/{event}` → same Zod shape as `EventCompanionFeed` |
| Source of truth | Hub `event` ACF + seminars agenda CPT rows |
| Cache | Short TTL; invalidate on agenda save |
| Auth | Public read for demo; private later if needed |

App load path today: see [`DATA_FEED.md`](./DATA_FEED.md). Shared Zod package: optional **A5** (`EventCompanionFeed` in `contracts/schema/`).

**Do not** switch the shipped demo to live REST without Owner approval — would change acceptance and Hostinger ops.
