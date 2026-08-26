import { useEffect, useState } from 'react'

import { FeedLoadError, loadCatalog } from '@/lib/feed'
import { HUB_EVENTS_URL, type CompanionCatalog } from '@/lib/schema'
import { applyProgrammeTheme } from '@/lib/theme'

export function ProgrammePickerView() {
  const [catalog, setCatalog] = useState<CompanionCatalog | null>(null)
  const [error, setError] = useState<Error | null>(null)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    applyProgrammeTheme(null)
  }, [])

  useEffect(() => {
    let cancelled = false
    ;(async () => {
      setLoading(true)
      setError(null)
      try {
        const data = await loadCatalog()
        if (!cancelled) setCatalog(data)
      } catch (err) {
        if (!cancelled) setError(err instanceof Error ? err : new Error(String(err)))
      } finally {
        if (!cancelled) setLoading(false)
      }
    })()
    return () => {
      cancelled = true
    }
  }, [])

  if (loading) {
    return (
      <main
        className="mx-auto max-w-3xl px-4 py-16 text-ink-muted"
        aria-busy="true"
        aria-live="polite"
      >
        Loading programmes…
      </main>
    )
  }

  if (error || !catalog) {
    return (
      <main className="mx-auto max-w-lg px-4 py-16">
        <h1 className="font-display text-2xl font-bold text-ink">Couldn’t load programmes</h1>
        <p className="mt-2 text-sm text-ink-muted">
          {error instanceof FeedLoadError ? error.message : 'Unexpected error.'}
        </p>
        <a
          href={HUB_EVENTS_URL}
          className="mt-6 inline-flex min-h-11 items-center rounded-sm border border-ink/15 bg-paper-card px-4 py-2.5 text-sm font-semibold text-ink"
        >
          All hub events
        </a>
      </main>
    )
  }

  return (
    <main className="mx-auto flex min-h-screen max-w-3xl flex-col px-4 py-12 sm:px-6">
      <p className="text-xs font-semibold uppercase tracking-[0.14em] text-accent-light">
        Companion demo
      </p>
      <h1 className="mt-2 font-display text-3xl font-bold tracking-tight text-ink sm:text-4xl">
        Choose a programme
      </h1>
      <p className="mt-3 max-w-xl text-sm text-ink-muted">
        One day-of schedule app for MSR Events — pick a programme, then return to the website
        anytime. Booking stays on WordPress.
      </p>

      <ul className="mt-8 flex flex-col gap-4" aria-label="Programmes">
        {catalog.programmes.map((p) => {
          const ready = p.status === 'ready'
          const stub = p.status === 'stub'
          const openable = ready || stub
          return (
            <li
              key={p.id}
              className="rounded-sm border border-ink/10 bg-paper-card p-5 shadow-soft"
            >
              <div className="flex flex-wrap items-start justify-between gap-2">
                <h2 className="font-display text-xl font-bold text-ink">{p.title}</h2>
                <span
                  className={`rounded-sm px-2.5 py-0.5 text-xs font-semibold ${
                    ready
                      ? 'bg-accent-soft text-accent-light'
                      : stub
                        ? 'bg-accent-soft text-accent-light'
                        : 'bg-ink/10 text-ink-muted'
                  }`}
                >
                  {ready ? 'Schedule ready' : stub ? 'Website-led' : 'Website only'}
                </span>
              </div>
              <p className="mt-2 text-sm text-ink-muted">{p.blurb}</p>
              <div className="mt-4 flex flex-wrap gap-3">
                {openable ? (
                  <a
                    href={`?event=${encodeURIComponent(p.id)}`}
                    className="inline-flex min-h-11 items-center rounded-sm bg-accent px-4 py-2.5 text-sm font-semibold text-on-accent hover:bg-accent-dark"
                  >
                    {ready ? 'Open schedule' : 'Open companion'}
                  </a>
                ) : (
                  <a
                    href={p.site_url}
                    className="inline-flex min-h-11 items-center rounded-sm border border-dashed border-ink/20 px-4 py-2.5 text-sm font-medium text-ink-muted hover:border-ink/40 hover:text-ink"
                  >
                    Browse website
                  </a>
                )}
                <a
                  href={p.site_url}
                  className="inline-flex min-h-11 items-center rounded-sm border border-ink/15 bg-paper px-4 py-2.5 text-sm font-semibold text-ink hover:border-ink/30"
                >
                  Programme website
                </a>
                {p.event_page_url ? (
                  <a
                    href={p.event_page_url}
                    className="inline-flex min-h-11 items-center text-sm font-medium text-accent-light underline-offset-2 hover:underline"
                  >
                    Hub event page
                  </a>
                ) : null}
              </div>
            </li>
          )
        })}
      </ul>

      <p className="mt-10 text-sm text-ink-muted">
        Or browse{' '}
        <a
          href={catalog.hub_events_url}
          className="font-semibold text-accent-light underline-offset-2 hover:underline"
        >
          all hub events
        </a>{' '}
        on the Events website.
      </p>
    </main>
  )
}
