# Session ID map — Event Companion ↔ Seminars agenda

**Verified:** 2026-08-21 against live `http://msrevents.local:8888/msrseminars/agenda/` (36 anchors).

**Source of truth (web):** `msrseminars_get_session_anchor_id( $agenda_post_id, $row_index )`  
→ HTML `id` / `.ics` filename stem: `seminars-session-{post_id}-{index}`  
→ ICS `UID`: `session-{post_id}-{index}@{host}`

**Companion JSON:** `sessions[].id` **must equal** the HTML anchor id (same string).  
**Feed:** `public/data/msrseminars.json` · **Load path:** [`DATA_FEED.md`](./DATA_FEED.md)

**Agenda content seed days:** Day 1 `20260618`, Day 2 `20260619`.

## Live agenda post IDs

| Track (seed slug) | Agenda post title | Live post ID | Day |
|-------------------|-------------------|--------------|-----|
| `training` | Training | **313** | 2026-06-18 |
| `academic` | Academic | **232** | 2026-06-18 |
| `leadership` | Leadership | **353** | 2026-06-18 |
| `technology` | Technology | **354** | 2026-06-19 |
| `social` | Social | **239** | 2026-06-19 |

Re-check after agenda reseed / PR-5:

```bash
curl -sS "http://msrevents.local:8888/msrseminars/agenda/" \
  | rg -o 'id="seminars-session-[0-9]+-[0-9]+"' | sort -u
```

## Sessions in `msrseminars.json` (A1)

| JSON `id` | Track | Index | Session title |
|-----------|-------|-------|---------------|
| `seminars-session-313-1` | training | 1 | Opening keynote: The future of workforce learning |
| `seminars-session-313-2` | training | 2 | Workshop: Facilitation masterclass |
| `seminars-session-313-4` | training | 4 | Panel: Measuring training impact |
| `seminars-session-353-0` | leadership | 0 | Keynote: Leading through uncertainty |
| `seminars-session-232-0` | academic | 0 | Research keynote: Evidence in professional practice |
| `seminars-session-354-1` | technology | 1 | Keynote: AI in the enterprise |
| `seminars-session-239-5` | social | 5 | Closing keynote: What we take back to work |

## A3b gate

Add-to-calendar / deep links are **blocked** until every shipped `sessions[].id` matches a live agenda anchor (A1 map above is the gate for the current feed subset).

## Awards (C1b) — no session ids

MSR Awards has **no agenda CPT**. `msrawards.json` uses `mode: "stub"` with empty `tracks` / `sessions`. Do **not** invent ceremony run-of-show ids. If Awards later grows an agenda, add a map here in the same slice as the schedule feed.
