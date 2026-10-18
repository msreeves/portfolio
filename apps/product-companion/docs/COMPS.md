# Event companion comps — portfolio keep / skip

Research for optional polish (A3b+). This is a **portfolio demonstration**, not a live booking or native App Store product.

## WEB PROOF (summary)

### Frame
What schedule-UX patterns from real event companions fit a **link-out React demo** without auth, push, or maps?

### Primary
Repo locks: one SPA, Seminars JSON, my-agenda localStorage, WP link-out CTAs, no native app.

### Drivers
Portfolio clarity · demo reliability · no live ops · match A0 “companion demo” copy.

### Axes
1. Core schedule UX  
2. Personalisation  
3. Calendar handoff  
4. Live-platform extras to **skip**

### Named findings
| Finding | Axis | Source |
|---------|------|--------|
| Session scheduler + personalised agenda are table stakes | 1–2 | CES / FETC / doTERRA store listings; Whova/Cvent comps |
| Add session → local calendar (ICS) is standard even in simple companions | 3 | AGIFORS Conference Companion; ICS guides |
| Track / category filter valued on multi-track programmes | 1 | G2 EventMobi/Whova agenda notes |
| Networking, push, maps, polls, AI, check-in need live backends | 4 | Whova / Cvent Attendee Hub |
| Offline / light static feeds avoid venue Wi‑Fi pain | 1 | CES 2025 Play reviews (connectivity failures) |

### Delta (owner-facing)

| Idea | Decision |
|------|----------|
| ICS add-to-calendar + export My agenda | **Add (A3b)** |
| Track filter chips | **Add** (portfolio polish) |
| QR on hub event single | **Defer** (print/ops; weak without B5 prod URL) |
| Networking / push / maps / gamification | **Skip** |
| Live REST feed | **A4 docs only** — keep static JSON |
| Shared Zod in contracts | **Defer A5** unless drift becomes painful |

### Queries
- `event companion app features schedule agenda my sessions add to calendar 2024 2025`
- `Whova Cvent Attendee Hub vs mobile event app features schedule favorites`
- `add to calendar ICS download session conference companion app best practice`
