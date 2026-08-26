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

/**
 * Composition kit Pilot B: S-spa-banner (R8) → H1 stack → CTA pair (R3).
 * Banner stays slim and below H1 visual weight — not a second hero.
 */
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
  const siteExit = feed.site_url
  const eventExit = feed.event_page_url

  const bannerExtra = [
    bookingIsMailto ? 'Register opens a demo mailto — not live booking.' : null,
    agendaIsLocalHost ? 'Full web agenda needs local MAMP / msrevents.local.' : null,
  ]
    .filter(Boolean)
    .join(' ')

  return (
    <header
      className="relative z-30 animate-rise border-b border-ink/10 bg-paper-card/95 backdrop-blur"
      data-msr-section="S-spa-shell"
    >
      <div className="mx-auto flex max-w-3xl flex-col gap-[var(--msr-stack-gap)] px-4 py-4 sm:px-6">
        <div className="flex flex-wrap items-center justify-between gap-2">
          <a
            href={siteExit}
            className="inline-flex min-h-11 items-center gap-1.5 rounded-sm border border-ink/15 bg-paper px-3 py-2 text-sm font-semibold text-ink transition hover:border-accent/40 hover:text-accent-light"
          >
            <span aria-hidden="true">←</span>
            Back to website
          </a>
          <div className="flex flex-wrap items-center gap-3">
            <a
              href="./"
              className="text-sm font-medium text-ink-muted underline-offset-2 hover:text-accent-light hover:underline"
            >
              All programmes
            </a>
            {eventExit ? (
              <a
                href={eventExit}
                className="text-sm font-medium text-ink-muted underline-offset-2 hover:text-accent-light hover:underline"
              >
                Hub event page
              </a>
            ) : null}
          </div>
        </div>

        {/* R8 — slim demo banner before H1; padding = tight; no accent fill competing with title */}
        <div
          className="msr-companion-banner rounded-sm border border-ink/15 bg-paper-mid/50 px-3 py-2 text-xs leading-snug text-ink-muted"
          role="note"
          data-msr-section="S-spa-banner"
        >
          <p>
            <span className="font-semibold text-ink">Portfolio companion demo</span>
            {' — '}
            Not an App Store product.
            {bannerExtra ? ` ${bannerExtra}` : ''}
          </p>
        </div>

        <div className="flex flex-wrap items-start justify-between gap-[var(--msr-stack-gap)]">
          <div>
            <p className="text-xs font-semibold uppercase tracking-[0.14em] text-accent-light">
              Companion demo
            </p>
            <h1 className="mt-[var(--msr-stack-gap-tight)] font-display text-3xl font-bold tracking-tight text-ink sm:text-4xl">
              {feed.title}
            </h1>
            <p className="mt-[var(--msr-stack-gap-tight)] max-w-xl text-sm text-ink-muted">
              Day-of schedule for the programme website — save sessions, see what’s on now, then
              register on the same booking URL as WordPress.
            </p>
          </div>
          <span className="rounded-sm bg-ink/10 px-3 py-1 text-xs font-semibold text-ink">
            {phaseLabel(phase)}
          </span>
        </div>

        <div className="flex flex-wrap items-center gap-[var(--msr-grid-gap)]">
          {showRegister ? (
            <a
              href={feed.booking_url}
              className="inline-flex min-h-11 items-center justify-center rounded-sm bg-accent px-4 py-2.5 text-sm font-semibold text-on-accent shadow-soft transition hover:bg-accent-dark"
            >
              Register
              {bookingIsMailto ? ' (demo)' : ''}
            </a>
          ) : (
            <a
              href={feed.agenda_url || '#'}
              className="inline-flex min-h-11 items-center justify-center rounded-sm bg-chrome px-4 py-2.5 text-sm font-semibold text-paper transition hover:opacity-90"
            >
              Programme resources
            </a>
          )}
          {feed.agenda_url ? (
            <a
              href={feed.agenda_url}
              target="_blank"
              rel="noreferrer"
              className="inline-flex min-h-11 items-center justify-center rounded-sm border border-ink/15 bg-paper-card px-4 py-2.5 text-sm font-semibold text-ink transition hover:border-ink/30"
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
