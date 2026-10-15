# Portfolio mini-demos (not MSR Projects)

Static/SPA **showcase** folders for the portfolio site (`sites/portfolio/`).

| This path | Not this |
|-----------|----------|
| `sites/portfolio/projects/*` | Repo-root `projects/comic/` (graphic novel production) |
| Case studies & demos on portfolio | **Projects** app `http://127.0.0.1:4088/` |

Card JSON: `*.json` here. `hub: false` — demos are **not** nested on the Sites hub (open **Portfolio** on Sites instead).

## Stack C — assets on active case studies (L2)

**Not Stack A** — do not link `localhost/workspace-*` or workspace nav here.

| Surface | Asset model |
|---------|-------------|
| Portfolio home (`index.php`) | `includes/vendor-assets.php` → `./vendor/…` |
| Case study under `projects/{slug}/` | Self-hosted **`../../vendor/…`** (fonts, Bootstrap, Font Awesome + v4-shims) then `../../css/style.css` · or PHP `cms_vendor_href_projects()` from `vendor-assets.php` |
| Built SPAs (`atlas-ops`, `event-companion`) | Vite build output only — no CDN Bootstrap on ship tree |
| Legacy demos (`game`, `movie-api`, …) | **Legacy exhibit** — CDN OK until owner unparks |

**Live-safe:** no `:4088` / `:4090` / `:4000` / `127.0.0.1` CTAs on shippable HTML; prose-only local notes OK. Gate: `npm run estate:live-ship:check` from repo root.
