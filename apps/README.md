# Portfolio app sources

React (and similar) **source apps** that ship as static demos under `sites/portfolio/projects/`.

| Path | Role |
|------|------|
| `apps/<slug>/` | Develop here (`npm run dev`) |
| `projects/<slug>/` | Shipped build Apache serves |
| `projects/<slug>.json` | Hub + archive card metadata |

## Atlas Ops

```bash
cd sites/portfolio/apps/atlas-ops
npm run dev              # local Vite
npm run ship:portfolio   # build → sites/portfolio/projects/atlas-ops/
```

Decisions: `apps/atlas-ops/PORTFOLIO_SHIP.md`

## Event Companion

```bash
cd sites/portfolio/apps/event-companion
npm run dev              # after A2 scaffold
npm run ship:portfolio   # after B1 → sites/portfolio/projects/event-companion/
```

Decisions: `apps/event-companion/PORTFOLIO_SHIP.md` · playbook `docs/plans/msr-event-companion-playbook.md`
