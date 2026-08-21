import type { Session } from './schema'

/** Escape text for iCalendar (RFC 5545). */
function icsEscape(value: string): string {
  return value
    .replace(/\\/g, '\\\\')
    .replace(/;/g, '\\;')
    .replace(/,/g, '\\,')
    .replace(/\r?\n/g, '\\n')
}

/** UTC stamp YYYYMMDDTHHMMSSZ */
function toIcsUtc(date: Date): string {
  const y = date.getUTCFullYear()
  const m = String(date.getUTCMonth() + 1).padStart(2, '0')
  const d = String(date.getUTCDate()).padStart(2, '0')
  const h = String(date.getUTCHours()).padStart(2, '0')
  const min = String(date.getUTCMinutes()).padStart(2, '0')
  const s = String(date.getUTCSeconds()).padStart(2, '0')
  return `${y}${m}${d}T${h}${min}${s}Z`
}

function foldLine(line: string): string {
  if (line.length <= 75) return line
  const parts: string[] = []
  let rest = line
  parts.push(rest.slice(0, 75))
  rest = rest.slice(75)
  while (rest.length) {
    parts.push(` ${rest.slice(0, 74)}`)
    rest = rest.slice(74)
  }
  return parts.join('\r\n')
}

function vevent(session: Session): string {
  const uid = `${session.id}@event-companion.msreeves`
  const stamp = toIcsUtc(new Date())
  const start = toIcsUtc(new Date(session.starts_at))
  const end = toIcsUtc(new Date(session.ends_at))
  const desc = [session.summary, session.agenda_url].filter(Boolean).join('\n')
  const lines = [
    'BEGIN:VEVENT',
    `UID:${uid}`,
    `DTSTAMP:${stamp}`,
    `DTSTART:${start}`,
    `DTEND:${end}`,
    `SUMMARY:${icsEscape(session.title)}`,
    desc ? `DESCRIPTION:${icsEscape(desc)}` : '',
    `CATEGORIES:${icsEscape(session.track)}`,
    'END:VEVENT',
  ].filter(Boolean)
  return lines.map(foldLine).join('\r\n')
}

/** Build a VCALENDAR body for one or more sessions. */
export function buildIcs(
  sessions: Session[],
  opts: { calendarName?: string } = {},
): string {
  const name = opts.calendarName ?? 'MSR Event Companion'
  const events = sessions.map((s) => vevent(s)).join('\r\n')
  const body = [
    'BEGIN:VCALENDAR',
    'VERSION:2.0',
    'PRODID:-//MSR//EventCompanion//EN',
    'CALSCALE:GREGORIAN',
    'METHOD:PUBLISH',
    `X-WR-CALNAME:${icsEscape(name)}`,
    events,
    'END:VCALENDAR',
  ].join('\r\n')
  return body.endsWith('\r\n') ? body : `${body}\r\n`
}

/** Trigger a browser download of an .ics file (portfolio demo — no server). */
export function downloadIcs(filename: string, sessions: Session[], calendarName?: string): void {
  if (!sessions.length) return
  const ics = buildIcs(sessions, { calendarName })
  const blob = new Blob([ics], { type: 'text/calendar;charset=utf-8' })
  const url = URL.createObjectURL(blob)
  const a = document.createElement('a')
  a.href = url
  a.download = filename.endsWith('.ics') ? filename : `${filename}.ics`
  a.rel = 'noopener'
  document.body.appendChild(a)
  a.click()
  a.remove()
  URL.revokeObjectURL(url)
}
