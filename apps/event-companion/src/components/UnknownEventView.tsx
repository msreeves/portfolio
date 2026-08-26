import { useEffect } from 'react'

import { HUB_EVENTS_URL } from '@/lib/schema'
import { applyProgrammeTheme } from '@/lib/theme'

type Props = {
  event: string
}

export function UnknownEventView({ event }: Props) {
  useEffect(() => {
    applyProgrammeTheme(null)
  }, [])

  return (
    <main className="mx-auto flex min-h-screen max-w-lg flex-col px-4 py-16 sm:px-6">
      <a
        href={HUB_EVENTS_URL}
        className="mb-6 inline-flex min-h-11 w-fit items-center gap-1.5 rounded-sm border border-ink/15 bg-paper-card px-3 py-2 text-sm font-semibold text-ink transition hover:border-accent/40 hover:text-accent-light"
      >
        <span aria-hidden="true">←</span>
        Hub events
      </a>
      <p className="text-xs font-semibold uppercase tracking-[0.14em] text-accent-light">
        Companion demo
      </p>
      <h1 className="mt-2 font-display text-3xl font-bold text-ink">Event not available</h1>
      <p className="mt-3 text-ink-muted">
        No schedule feed for <code className="rounded-sm bg-ink/10 px-1.5 py-0.5 text-sm">{event}</code>
        .
      </p>
      <p className="mt-2 text-sm text-ink-muted">
        Choose a programme from the picker, or open a known schedule.
      </p>
      <div className="mt-8 flex flex-col gap-3">
        <a
          href="./"
          className="inline-flex min-h-11 w-fit items-center rounded-sm bg-accent px-4 py-2.5 text-sm font-semibold text-on-accent hover:bg-accent-dark"
        >
          All programmes
        </a>
        <a
          href="?event=msrseminars"
          className="inline-flex min-h-11 w-fit items-center rounded-sm border border-ink/15 bg-paper-card px-4 py-2.5 text-sm font-semibold text-ink hover:border-ink/30"
        >
          MSR Seminars schedule
        </a>
        <a
          href="?event=msrawards"
          className="inline-flex min-h-11 w-fit items-center rounded-sm border border-ink/15 bg-paper-card px-4 py-2.5 text-sm font-semibold text-ink hover:border-ink/30"
        >
          MSR Awards companion
        </a>
      </div>
    </main>
  )
}
