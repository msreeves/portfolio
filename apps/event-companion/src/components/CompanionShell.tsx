import type { DelegatePhase, EventCompanionFeed } from '@/lib/schema'
import { phaseLabel } from './SessionCard'

type Props = {
  feed: EventCompanionFeed
  clockDisplay: string
  clockIso: string
  usingDemoClock: boolean
  bookingIsMailto: boolean
  agendaIsLocalHost: boolean
}

export function CompanionShell({
  feed,
  clockDisplay,
  clockIso,
  usingDemoClock,
  bookingIsMailto,
  agendaIsLocalHost,
}: Props) {
  const phase: DelegatePhase = feed.delegate_phase
  const showRegister = phase === 'registration' || phase === 'during'

  return (
    <header className="animate-rise border-b border-ink/10 bg-paper-card/90 backdrop-blur">
      <div className="mx-auto flex max-w-3xl flex-col gap-4 px-4 py-5 sm:px-6">
        <div
          className="rounded-xl border border-teal/25 bg-teal-soft/60 px-3 py-2.5 text-sm text-ink"
          role="note"
        >
          <p className="font-semibold text-teal-dark">Portfolio companion demo</p>
          <p className="mt-0.5 text-ink-muted">
            Not an App Store product.
            {bookingIsMailto
              ? ' Register opens a demo mailto — not a live booking system.'
              : ' Register uses the same booking URL as the programme website.'}
            {agendaIsLocalHost
              ? ' Full web agenda needs local MAMP / msrevents.local.'
              : ''}
          </p>
        </div>

        <div className="flex flex-wrap items-start justify-between gap-3">
          <div>
            <p className="text-xs font-semibold uppercase tracking-[0.14em] text-teal-dark">
              Companion demo
            </p>
            <h1 className="mt-1 font-display text-3xl font-bold tracking-tight text-ink sm:text-4xl">
              {feed.title}
            </h1>
            <p className="mt-2 max-w-xl text-sm text-ink-muted">
              Day-of schedule for the programme website — save sessions, see what’s on now, then
              register on the same booking URL as WordPress.
            </p>
          </div>
          <span className="rounded-full bg-ink/5 px-3 py-1 text-xs font-semibold text-ink">
            {phaseLabel(phase)}
          </span>
        </div>

        <div className="flex flex-wrap items-center gap-3">
          {showRegister ? (
            <a
              href={feed.booking_url}
              className="inline-flex min-h-11 items-center justify-center rounded-xl bg-teal px-4 py-2.5 text-sm font-semibold text-white shadow-soft transition hover:bg-teal-dark"
            >
              Register
              {bookingIsMailto ? ' (demo)' : ''}
            </a>
          ) : (
            <a
              href={feed.agenda_url || '#'}
              className="inline-flex min-h-11 items-center justify-center rounded-xl bg-ink px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-ink/90"
            >
              Programme resources
            </a>
          )}
          {feed.agenda_url ? (
            <a
              href={feed.agenda_url}
              target="_blank"
              rel="noreferrer"
              className="inline-flex min-h-11 items-center justify-center rounded-xl border border-ink/15 bg-paper-card px-4 py-2.5 text-sm font-semibold text-ink transition hover:border-ink/30"
            >
              Full web agenda
            </a>
          ) : null}
        </div>

        <p className="text-xs text-ink-muted">
          Clock:{' '}
          <time dateTime={clockIso}>{clockDisplay}</time>
          {usingDemoClock ? ' · demo clock (outside programme dates)' : ''}
          {' · '}
          {feed.timezone}
        </p>
      </div>
    </header>
  )
}
