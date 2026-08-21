import type { DelegatePhase, Session } from '@/lib/schema'
import { formatTimeRange } from '@/lib/time'

type Props = {
  session: Session
  trackLabel: string
  timeZone: string
  saved: boolean
  onToggleSave: () => void
  onCalendar: () => void
  live?: boolean
}

export function SessionCard({
  session,
  trackLabel,
  timeZone,
  saved,
  onToggleSave,
  onCalendar,
  live = false,
}: Props) {
  return (
    <article
      className={`rounded-2xl border bg-paper-card p-4 shadow-soft transition motion-safe:hover:-translate-y-0.5 ${
        live ? 'border-ink ring-1 ring-ink/20' : 'border-ink/10'
      }`}
    >
      <div className="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div className="min-w-0 flex-1">
          <div className="mb-1 flex flex-wrap items-center gap-2 text-xs font-medium uppercase tracking-wide text-ink-muted">
            {live ? (
              <span className="inline-flex items-center gap-1.5 rounded-full bg-teal-soft px-2 py-0.5 text-teal-dark">
                <span className="live-dot inline-block h-1.5 w-1.5 rounded-full bg-teal" aria-hidden />
                On now
              </span>
            ) : null}
            <span>{trackLabel}</span>
            <span aria-hidden>·</span>
            <span>{session.format}</span>
          </div>
          <h3 className="font-display text-lg font-semibold leading-snug text-ink">{session.title}</h3>
          <p className="mt-1 text-sm text-ink-muted">{formatTimeRange(session, timeZone)}</p>
          {session.summary ? (
            <p className="mt-2 text-sm leading-relaxed text-ink/80">{session.summary}</p>
          ) : null}
          {session.agenda_url ? (
            <p className="mt-3">
              <a
                className="text-sm font-medium text-teal-dark underline-offset-2 hover:underline"
                href={session.agenda_url}
                target="_blank"
                rel="noreferrer"
              >
                View on web agenda
              </a>
            </p>
          ) : null}
        </div>

        <div className="flex shrink-0 flex-row flex-wrap items-center gap-2 sm:flex-col sm:items-stretch">
          <button
            type="button"
            onClick={onToggleSave}
            aria-pressed={saved}
            className={`min-h-11 rounded-xl px-3 py-2 text-sm font-semibold transition ${
              saved
                ? 'bg-ink text-white hover:bg-ink/90'
                : 'bg-ink/5 text-ink hover:bg-ink/10'
            }`}
          >
            {saved ? 'Saved' : 'Save'}
          </button>
          <button
            type="button"
            onClick={onCalendar}
            className="min-h-11 rounded-xl border border-ink/15 bg-transparent px-3 py-2 text-sm font-medium text-ink-muted underline-offset-2 hover:border-ink/30 hover:text-ink hover:underline"
          >
            Add to calendar
          </button>
        </div>
      </div>
    </article>
  )
}

export function phaseLabel(phase: DelegatePhase): string {
  switch (phase) {
    case 'registration':
      return 'Registration open'
    case 'during':
      return 'Event in progress'
    case 'replay':
      return 'Replay / resources'
  }
}
