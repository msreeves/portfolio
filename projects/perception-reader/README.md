# Perception reader URL (portfolio)

Stable path for bookmarks and legacy links: `/projects/perception-reader/`.

**Current behaviour:** styled alias landing with links to overview, case study, and [`../perception/gallery.html`](../perception/gallery.html) (not a lettered page-flip reader).

To reinstall this stub after an accidental live-pack sync:

```bash
npm run portfolio:perception-reader:sync
```

For the Stack D engineering reader pack (export tests only):

```bash
PORTFOLIO_PERCEPTION_READER_MODE=live-pack npm run portfolio:perception-reader:sync
```
