# Stack C — Portfolio

**Fence:** `site.json` + `css/style.css` · no WP/Vite merge with programme themes.

| Read first | Role |
|------------|------|
| [`docs/reference/estate-read-map.md`](../../docs/reference/estate-read-map.md) § Stack C | Section map · banned reads |
| [`.cursor/rules/portfolio-agent.mdc`](../../.cursor/rules/portfolio-agent.mdc) | Data source · acceptance |
| [`docs/reference/estate-governance-map.md`](../../docs/reference/estate-governance-map.md) §0d | Gates |

**Data:** `data/site.json` · `projects/*.json` · `includes/site-bootstrap.php` (large — read section map first).

**Gates:** `edit:verify` · `ACCEPTANCE_CONFIG=config/portfolio-acceptance.json npm run msr:acceptance` · `review:site -- portfolio`.

**Local URL:** `http://127.0.0.1:8888/sites/portfolio/`
