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
