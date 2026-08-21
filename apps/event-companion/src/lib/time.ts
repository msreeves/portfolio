import type { EventCompanionFeed, Session } from './schema'

/** Portfolio demos often run outside programme dates — pin a sensible “now”. */
export function resolveNow(feed: EventCompanionFeed, search = window.location.search): Date {
  const params = new URLSearchParams(search)
  const override = params.get('now')
  if (override) {
    const parsed = new Date(override)
    if (!Number.isNaN(parsed.getTime())) return parsed
  }

  const real = new Date()
  const inWindow = feed.demo_dates.some((day) => {
    const start = new Date(`${day}T00:00:00+01:00`)
    const end = new Date(`${day}T23:59:59+01:00`)
    return real >= start && real <= end
  })
  if (inWindow) return real

  const demoDay = feed.demo_dates[0] ?? '2026-06-18'
  return new Date(`${demoDay}T10:15:00+01:00`)
}

export function ymdInLondon(date: Date): string {
  return new Intl.DateTimeFormat('en-CA', {
    timeZone: 'Europe/London',
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
  }).format(date)
}

/** Human clock for the feed timezone. */
export function formatClockLabel(date: Date, timeZone: string): string {
  return new Intl.DateTimeFormat('en-GB', {
    timeZone,
    weekday: 'short',
    day: 'numeric',
    month: 'short',
    hour: 'numeric',
    minute: '2-digit',
  }).format(date)
}

/** Day chip label e.g. "Day 1 · Wed 18 Jun". */
export function formatDayChip(ymd: string, index: number, timeZone: string): string {
  const noon = new Date(`${ymd}T12:00:00+01:00`)
  const short = new Intl.DateTimeFormat('en-GB', {
    timeZone,
    weekday: 'short',
    day: 'numeric',
    month: 'short',
  }).format(noon)
  return `Day ${index + 1} · ${short}`
}

export function formatTimeRange(session: Session, timeZone: string): string {
  const start = new Date(session.starts_at)
  const end = new Date(session.ends_at)
  const opts: Intl.DateTimeFormatOptions = {
    timeZone,
    hour: 'numeric',
    minute: '2-digit',
  }
  const a = new Intl.DateTimeFormat('en-GB', opts).format(start)
  const b = new Intl.DateTimeFormat('en-GB', opts).format(end)
  return `${a} – ${b}`
}

export function sessionsForDay(sessions: Session[], dayYmd: string): Session[] {
  return sessions
    .filter((s) => ymdInLondon(new Date(s.starts_at)) === dayYmd)
    .sort((a, b) => +new Date(a.starts_at) - +new Date(b.starts_at))
}

export function onNowSessions(sessions: Session[], now: Date): Session[] {
  const t = now.getTime()
  return sessions
    .filter((s) => {
      const start = new Date(s.starts_at).getTime()
      const end = new Date(s.ends_at).getTime()
      return start <= t && t < end
    })
    .sort((a, b) => +new Date(a.starts_at) - +new Date(b.starts_at))
}

export function upcomingSessions(sessions: Session[], now: Date, limit = 4): Session[] {
  const t = now.getTime()
  return sessions
    .filter((s) => new Date(s.starts_at).getTime() > t)
    .sort((a, b) => +new Date(a.starts_at) - +new Date(b.starts_at))
    .slice(0, limit)
}
