import { useCallback, useEffect, useId, useMemo, useState, type KeyboardEvent } from 'react'

import { CompanionShell } from '@/components/CompanionShell'
import { ProgrammePickerView } from '@/components/ProgrammePickerView'
import { SessionCard } from '@/components/SessionCard'
import { StubProgrammeView } from '@/components/StubProgrammeView'
import { Toast } from '@/components/Toast'
import { UnknownEventView } from '@/components/UnknownEventView'
import {
  assertKnownEvent,
  FeedLoadError,
  loadFeed,
  readEventParam,
  UnknownEventError,
} from '@/lib/feed'
import { downloadIcs } from '@/lib/ics'
import { loadSavedIds, toggleSavedId } from '@/lib/saved'
import type { EventCompanionFeed, Session } from '@/lib/schema'
import {
  formatClockLabel,
  formatDayChip,
  onNowSessions,
  resolveNow,
  sessionsForDay,
  upcomingSessions,
  ymdInLondon,
} from '@/lib/time'
import { applyProgrammeTheme } from '@/lib/theme'

type Tab = 'day' | 'on-now' | 'saved' | 'all'

const TAB_ORDER: Tab[] = ['day', 'on-now', 'saved', 'all']

function isLocalishHost(url: string): boolean {
  try {
    const u = new URL(url)
    return (
      u.hostname === '127.0.0.1' ||
      u.hostname === 'localhost' ||
      u.hostname.endsWith('.local')
    )
  } catch {
    return false
  }
}

export default function App() {
  const eventParam = readEventParam()

  if (eventParam === null) {
    return <ProgrammePickerView />
  }

  return <EventScheduleApp eventParam={eventParam} />
}

function EventScheduleApp({ eventParam }: { eventParam: string }) {
  const tablistId = useId()
  const panelId = 'schedule-panel'
  const [feed, setFeed] = useState<EventCompanionFeed | null>(null)
  const [error, setError] = useState<Error | null>(null)
  const [loading, setLoading] = useState(true)
  const [savedIds, setSavedIds] = useState<string[]>([])
  const [tab, setTab] = useState<Tab>('day')
  const [trackFilter, setTrackFilter] = useState<string>('all')
  const [selectedDay, setSelectedDay] = useState<string>('')
  const [toast, setToast] = useState<string | null>(null)

  const dismissToast = useCallback(() => setToast(null), [])

  useEffect(() => {
    let cancelled = false
    ;(async () => {
      setLoading(true)
      setError(null)
      try {
        const known = assertKnownEvent(eventParam)
        const data = await loadFeed(known)
        if (cancelled) return
        setFeed(data)
        setSavedIds(loadSavedIds(known))
        const clock = resolveNow(data)
        setSelectedDay(ymdInLondon(clock))
        if (data.delegate_phase === 'during') setTab('on-now')
        if (data.delegate_phase === 'replay') setTab('saved')
      } catch (err) {
        if (!cancelled) setError(err instanceof Error ? err : new Error(String(err)))
      } finally {
        if (!cancelled) setLoading(false)
      }
    })()
    return () => {
      cancelled = true
    }
  }, [eventParam])

  useEffect(() => {
    applyProgrammeTheme(feed?.event ?? eventParam)
  }, [feed?.event, eventParam])

  const now = useMemo(() => (feed ? resolveNow(feed) : new Date()), [feed])
  const usingDemoClock = useMemo(() => {
    if (!feed) return false
    const real = new Date()
    return !feed.demo_dates.some((day) => ymdInLondon(real) === day)
  }, [feed])

  const trackLabel = (session: Session) =>
    feed?.tracks.find((t) => t.id === session.track)?.label ?? session.track

  if (error instanceof UnknownEventError) {
    return <UnknownEventView event={error.event} />
  }

  if (loading) {
    return (
      <main
        className="mx-auto max-w-3xl px-4 py-16 text-ink-muted"
        aria-busy="true"
        aria-live="polite"
      >
        Loading companion schedule…
      </main>
    )
  }

  if (error || !feed) {
    return (
      <main className="mx-auto max-w-lg px-4 py-16">
        <h1 className="font-display text-2xl font-bold text-ink">Couldn’t load schedule</h1>
        <p className="mt-2 text-sm text-ink-muted">
          {error instanceof FeedLoadError ? error.message : 'Unexpected error.'}
        </p>
        <a
          href="./"
          className="mt-6 inline-flex min-h-11 items-center rounded-sm border border-ink/15 bg-paper-card px-4 py-2.5 text-sm font-semibold text-ink"
        >
          Choose a programme
        </a>
      </main>
    )
  }

  if (feed.mode === 'stub') {
    return <StubProgrammeView feed={feed} />
  }

  const dayYmd = selectedDay || ymdInLondon(now)
  const daySessions = sessionsForDay(feed.sessions, dayYmd)
  const live = onNowSessions(feed.sessions, now)
  const upcoming = upcomingSessions(feed.sessions, now)
  const saved = feed.sessions.filter((s) => savedIds.includes(s.id))

  const byTab: Session[] =
    tab === 'day'
      ? daySessions
      : tab === 'on-now'
        ? live.length
          ? live
          : upcoming
        : tab === 'saved'
          ? saved
          : [...feed.sessions].sort((a, b) => +new Date(a.starts_at) - +new Date(b.starts_at))

  const list: Session[] =
    trackFilter === 'all' ? byTab : byTab.filter((s) => s.track === trackFilter)

  const tabs: { id: Tab; label: string }[] = [
    { id: 'day', label: 'Day schedule' },
    { id: 'on-now', label: 'On now' },
    { id: 'saved', label: `My agenda (${savedIds.length})` },
    { id: 'all', label: 'All' },
  ]

  const bookingIsMailto = feed.booking_url.trim().toLowerCase().startsWith('mailto:')
  const agendaIsLocalHost = Boolean(feed.agenda_url && isLocalishHost(feed.agenda_url))

  const onToggle = (id: string) => {
    setSavedIds((prev) => {
      const next = toggleSavedId(feed.event, id, prev)
      const nowSaved = next.includes(id)
      setToast(nowSaved ? 'Saved to My agenda' : 'Removed from My agenda')
      return next
    })
  }

  const onCalendar = (session: Session) => {
    downloadIcs(`${session.id}.ics`, [session], session.title)
    setToast('Calendar file downloaded')
  }

  const exportSaved = () => {
    downloadIcs('msr-seminars-my-agenda.ics', saved, `${feed.title} — My agenda`)
    setToast('My agenda calendar file downloaded')
  }

  const onTabKeyDown = (e: KeyboardEvent, current: Tab) => {
    const i = TAB_ORDER.indexOf(current)
    if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
      e.preventDefault()
      const dir = e.key === 'ArrowRight' ? 1 : -1
      const next = TAB_ORDER[(i + dir + TAB_ORDER.length) % TAB_ORDER.length]
      setTab(next)
      document.getElementById(`${tablistId}-${next}`)?.focus()
    }
    if (e.key === 'Home') {
      e.preventDefault()
      setTab(TAB_ORDER[0])
      document.getElementById(`${tablistId}-${TAB_ORDER[0]}`)?.focus()
    }
    if (e.key === 'End') {
      e.preventDefault()
      const last = TAB_ORDER[TAB_ORDER.length - 1]
      setTab(last)
      document.getElementById(`${tablistId}-${last}`)?.focus()
    }
  }

  // R5 chips: hug content + wrap (not full-width stacked buttons)
  const chipSelected = 'bg-accent text-on-accent'
  const chipIdle = 'bg-paper-card text-ink shadow-soft hover:bg-paper-mid'
  const chipRow =
    'flex flex-wrap items-center gap-[var(--msr-stack-gap-tight)]'

  return (
    <div className="min-h-screen pb-20">
      <a
        href={`#${panelId}`}
        className="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded-lg focus:bg-chrome focus:px-3 focus:py-2 focus:text-sm focus:text-paper"
      >
        Skip to schedule
      </a>

      <CompanionShell
        feed={feed}
        clockDisplay={formatClockLabel(now, feed.timezone)}
        clockIso={now.toISOString()}
        usingDemoClock={usingDemoClock}
        bookingIsMailto={bookingIsMailto}
        agendaIsLocalHost={agendaIsLocalHost}
      />

      {/* Sticky chrome: day chips (R5) + view tabs — sticky under shell, not a second hero */}
      <div
        className="sticky top-0 z-40 border-b border-ink/10 bg-paper-card/95 backdrop-blur"
        data-msr-section="S-spa-chips"
      >
        <div className="mx-auto flex max-w-3xl flex-col gap-[var(--msr-stack-gap-tight)] px-4 py-3 sm:px-6">
          <div role="group" aria-label="Programme day" className={chipRow}>
            {feed.demo_dates.map((ymd, i) => (
              <button
                key={ymd}
                type="button"
                aria-pressed={dayYmd === ymd}
                onClick={() => {
                  setSelectedDay(ymd)
                  setTab('day')
                }}
                className={`min-h-10 shrink-0 rounded-sm px-3 py-2 text-sm font-semibold transition ${
                  dayYmd === ymd ? chipSelected : chipIdle
                }`}
              >
                {formatDayChip(ymd, i, feed.timezone)}
              </button>
            ))}
          </div>

          <div role="tablist" aria-label="Schedule views" className={chipRow}>
            {tabs.map((t) => (
              <button
                key={t.id}
                id={`${tablistId}-${t.id}`}
                type="button"
                role="tab"
                aria-selected={tab === t.id}
                aria-controls={panelId}
                tabIndex={tab === t.id ? 0 : -1}
                onClick={() => setTab(t.id)}
                onKeyDown={(e) => onTabKeyDown(e, t.id)}
                className={`min-h-11 rounded-sm px-3 py-2 text-sm font-semibold transition ${
                  tab === t.id ? chipSelected : chipIdle
                }`}
              >
                {t.label}
              </button>
            ))}
          </div>
        </div>
      </div>

      <main className="animate-rise-delay mx-auto max-w-3xl px-4 py-6 sm:px-6">
        {feed.delegate_phase === 'replay' ? (
          <p className="mb-6 rounded-sm border border-ink/10 bg-paper-card p-4 text-sm text-ink-muted">
            Replay phase — registration CTAs are quiet. Browse saved sessions or the web agenda for
            resources.
          </p>
        ) : null}

        {tab === 'on-now' && live.length === 0 ? (
          <p className="mb-4 text-sm text-ink-muted">
            Nothing live at the demo clock — showing up next.
          </p>
        ) : null}

        <div className={`mb-4 ${chipRow}`} role="group" aria-label="Filter by track">
          <button
            type="button"
            aria-pressed={trackFilter === 'all'}
            onClick={() => setTrackFilter('all')}
            className={`min-h-10 shrink-0 rounded-sm border px-3 py-1.5 text-xs font-semibold transition ${
              trackFilter === 'all'
                ? 'border-accent bg-accent text-on-accent'
                : 'border-ink/10 bg-paper-card text-ink-muted hover:text-ink'
            }`}
          >
            All tracks
          </button>
          {feed.tracks.map((t) => (
            <button
              key={t.id}
              type="button"
              aria-pressed={trackFilter === t.id}
              onClick={() => setTrackFilter(t.id)}
              className={`min-h-10 shrink-0 rounded-sm border px-3 py-1.5 text-xs font-semibold transition ${
                trackFilter === t.id
                  ? 'border-accent bg-accent text-on-accent'
                  : 'border-ink/10 bg-paper-card text-ink-muted hover:text-ink'
              }`}
            >
              {t.label}
            </button>
          ))}
        </div>

        {(tab === 'saved' && saved.length > 0) || (saved.length > 0 && tab !== 'saved') ? (
          <p className="mb-4 flex flex-wrap items-center gap-3">
            {tab === 'saved' ? (
              <button
                type="button"
                onClick={exportSaved}
                className="min-h-11 rounded-sm bg-chrome px-4 py-2 text-sm font-semibold text-paper hover:opacity-90"
              >
                Export my agenda (.ics)
              </button>
            ) : (
              <button
                type="button"
                onClick={() => setTab('saved')}
                className="text-sm font-medium text-accent-light underline-offset-2 hover:underline"
              >
                {saved.length} saved — open My agenda to export
              </button>
            )}
          </p>
        ) : null}

        <div id={panelId} role="tabpanel" aria-labelledby={`${tablistId}-${tab}`}>
          {list.length === 0 ? (
            <div className="rounded-sm border border-dashed border-ink/20 bg-paper-card/60 p-8 text-center text-ink-muted">
              <p>
                {tab === 'saved'
                  ? 'No saved sessions yet. Save from Day schedule or All.'
                  : trackFilter !== 'all'
                    ? 'No sessions for this track in the current view.'
                    : 'No sessions in this view.'}
              </p>
              {trackFilter !== 'all' ? (
                <button
                  type="button"
                  className="mt-4 min-h-11 rounded-sm bg-chrome px-4 py-2 text-sm font-semibold text-paper"
                  onClick={() => setTrackFilter('all')}
                >
                  Clear track filter
                </button>
              ) : null}
              {tab === 'day' && trackFilter === 'all' && daySessions.length === 0 ? (
                <button
                  type="button"
                  className="mt-4 min-h-11 rounded-sm border border-ink/20 px-4 py-2 text-sm font-semibold text-ink"
                  onClick={() => setTab('all')}
                >
                  Browse all sessions
                </button>
              ) : null}
            </div>
          ) : (
            <ul className="flex flex-col gap-4">
              {list.map((session) => (
                <li key={session.id}>
                  <SessionCard
                    session={session}
                    trackLabel={trackLabel(session)}
                    timeZone={feed.timezone}
                    saved={savedIds.includes(session.id)}
                    live={live.some((s) => s.id === session.id)}
                    onToggleSave={() => onToggle(session.id)}
                    onCalendar={() => onCalendar(session)}
                  />
                </li>
              ))}
            </ul>
          )}
        </div>
      </main>

      <footer className="mx-auto max-w-3xl px-4 pb-10 sm:px-6">
        <div className="mb-4 flex flex-wrap items-center gap-3 rounded-sm border border-ink/10 bg-paper-card px-4 py-3">
          <a
            href={feed.site_url}
            className="inline-flex min-h-11 items-center gap-1.5 text-sm font-semibold text-accent-light hover:underline"
          >
            <span aria-hidden="true">←</span>
            Back to website
          </a>
          {feed.event_page_url ? (
            <a
              href={feed.event_page_url}
              className="text-sm font-medium text-ink-muted hover:text-accent-light hover:underline"
            >
              Hub event page
            </a>
          ) : null}
          <a
            href="./"
            className="text-sm font-medium text-ink-muted hover:text-accent-light hover:underline"
          >
            All programmes
          </a>
        </div>
        <p className="rounded-sm border border-ink/10 bg-paper-mid/60 px-4 py-3 text-xs leading-relaxed text-ink-muted">
          {feed.disclaimer}
        </p>
      </footer>

      <Toast message={toast} onDismiss={dismissToast} />
    </div>
  )
}
