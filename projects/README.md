# Portfolio mini-demos (not MSR Projects)

Static/SPA **showcase** folders for the portfolio site (`sites/portfolio/`).

| This path | Not this |
|-----------|----------|
| `sites/portfolio/projects/*` | Repo-root `projects/comic/` (graphic novel production) |
| Case studies & demos on portfolio | **Projects** app `http://127.0.0.1:4088/` |

Card JSON: `*.json` here. `hub: false` — demos are **not** nested on the Sites hub (open **Portfolio** on Sites instead).

## Wired as an app (source → ship → card)

| Step | Path |
|------|------|
| Develop | `sites/portfolio/apps/<slug>/` (`npm run dev`) |
| Ship static demo | `npm run ship:portfolio` (or app’s ship script) → `sites/portfolio/projects/<slug>/` |
| Portfolio metadata | `sites/portfolio/projects/<slug>.json` — title, stack, summary, `view_url`, `active` |

Shipped demos are **apps with a real page** on Herd: `http://127.0.0.1/sites/portfolio/projects/<slug>/`.

**Extensionless static pages:** Herd nginx (`scripts/local/herd-workspace-roots.conf` → `location /sites/portfolio/projects/`) and `projects/.htaccess` strip `.html` from URLs. Link case studies as `./projects/<slug>/page` in `selected-work.json` — gate `portfolio-projects-routing-check` fails on `.html` suffixes.

## Local Making catalog (`:4088`) — opt-in only

`:4088` is for shortcuts to things you open while making — **not** a second portfolio grid.

| Field on `<slug>.json` | Effect |
|------------------------|--------|
| `"makingCatalog": true` | Card on `http://127.0.0.1:4088/` → **View** opens this shipped demo (local Herd URL) |
| omitted or `false` | Demo stays on portfolio / case study only (default) |

Requirements: `active: true`, built `projects/<slug>/index.html`. After changing flags: `npm run projects:catalog` from repo root.

**Do not** put `:4088` / `:4090` / `:4000` links in shipped demo HTML or card copy — gate `npm run estate:live-ship:check`.

## Stack C — assets on active case studies (L2)

**Not Stack A** — do not link `localhost/workspace-*` or workspace nav here.

| Surface | Asset model |
|---------|-------------|
| Portfolio home (`index.php`) | `includes/vendor-assets.php` → `./vendor/…` |
| Case study under `projects/{slug}/` | Self-hosted **`../../vendor/…`** (fonts, Bootstrap, Font Awesome + v4-shims) then `../../css/style.css` · or PHP `cms_vendor_href_projects()` from `vendor-assets.php` |
| Built SPAs (`atlas-ops`, `event-companion`) | Vite build output only — no CDN Bootstrap on ship tree |
| Legacy demos (`game`, `movie-api`, …) | **Legacy exhibit** — CDN OK until owner unparks |

**Live-safe:** no `:4088` / `:4090` / `:4000` / `127.0.0.1` CTAs on shippable HTML; prose-only local notes OK. Gate: `npm run estate:live-ship:check` from repo root.
