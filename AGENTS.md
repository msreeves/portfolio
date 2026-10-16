# Stack C — Portfolio

**All agents, all areas:** this folder follows the workspace one-team law — [`docs/law/agent-collaboration.md`](../../docs/law/agent-collaboration.md) · handover [`docs/reference/agent-handover.md`](../../docs/reference/agent-handover.md) · commits are automatic ([`repos.md`](../../docs/law/repos.md#automatic-commit--push-official-process)).

**Fence:** `site.json` + `css/style.css` · no WP/Vite merge with programme themes.

| Read first | Role |
|------------|------|
| [`docs/reference/estate-read-map.md`](../../docs/reference/estate-read-map.md) § Stack C | Section map · banned reads |
| [`.cursor/rules/portfolio-agent.mdc`](../../.cursor/rules/portfolio-agent.mdc) | Data source · acceptance |
| [`docs/reference/estate-governance-map.md`](../../docs/reference/estate-governance-map.md) §0d | Gates |

**Data:** `data/site.json` · `projects/*.json` · `includes/site-bootstrap.php` (large — read section map first).

**Gates:** `edit:verify` · `ACCEPTANCE_CONFIG=config/portfolio-acceptance.json npm run msr:acceptance` · `review:site -- portfolio`.

**Inset boxes:** card/panel copy uses `--msr-inset-*` tokens in `css/style.css`; programme/archive card thumbs use `object-fit: cover` in a `16/10` frame (portrait lead cards use `contain`).

**Local URL:** `http://127.0.0.1/sites/portfolio/`
