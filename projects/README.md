# Portfolio project demos

This folder holds **shipped** mini-sites and their **card JSON**. It is not the same as repo-root `projects/` (source / WIP).

## Layout

| Path | Purpose |
|------|---------|
| `<slug>/` | Built demo (static files Apache can serve) |
| `<slug>.json` | Card metadata — drives **localhost hub** + optional **archive** grid |
| `_project.card.example.json` | Template (ignored by loaders) |

## JSON fields

| Field | Required | Notes |
|-------|----------|--------|
| `slug` | recommended | Folder name under `projects/` |
| `title` | **yes** | Hub + archive label |
| `view_url` | **yes** (hub) | Relative, e.g. `./projects/my-demo/` |
| `thumb` | **yes** (archive) | Relative image path under portfolio |
| `stack` | recommended | Short tech line |
| `summary` | recommended | One–two sentences |
| `code_url` | recommended | GitHub URL |
| `order` | optional | Sort key (lower first). Default `9999` |
| `active` | optional | `false` hides everywhere. Default on |
| `hub` | optional | `false` hides on `http://127.0.0.1:8888/` Portfolio mini-sites. Default `true` |
| `archive` | optional | `false` hides from portfolio homepage archive accordion. Default `true` |

### Featured case studies (separate)

Recruiter “Lead case study” cards live in PHP:

`sites/portfolio/includes/site-bootstrap.php` → `cms_msr_case_study_cards()`

Use a card JSON with `"archive": false` when the demo is featured there, so it still appears on the **local hub** without duplicating the archive grid (see `atlas-ops.json`).

## Checklist for a new demo

1. Develop under `sites/portfolio/apps/<slug>/` (see `sites/portfolio/apps/README.md`). Non-portfolio sandboxes may still use repo-root `projects/` (e.g. comic).
2. Ship built assets to `sites/portfolio/projects/<slug>/` (correct Vite/`base` + SPA `.htaccess` if needed).
3. Copy `_project.card.example.json` → `<slug>.json` and fill fields.
4. Add thumb under `sites/portfolio/media/images/…`.
5. If featured: add `cms_msr_case_study_cards()` entry; set `"archive": false` on the JSON.
6. Refresh hub cache: `http://127.0.0.1:8888/?hub_refresh=1`
7. Confirm: hub mini-site link + portfolio live URL.

## Current cards

| JSON | Hub | Archive |
|------|-----|---------|
| `atlas-ops.json` | yes | no (featured case study) |
| `movie-api.json` | yes | yes |
| `game.json` | yes | yes |
| `hairdressing.json` | yes | yes |
