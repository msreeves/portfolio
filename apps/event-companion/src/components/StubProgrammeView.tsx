import { useEffect } from 'react'

import type { EventCompanionFeed } from '@/lib/schema'
import { applyProgrammeTheme } from '@/lib/theme'

type Props = {
  feed: EventCompanionFeed
}

const DEFAULT_STUB =
  'This programme has no session agenda in the companion. Use the website for the live programme, then return here when a schedule exists.'

/**
 * C1b — website-led programme (no agenda CPT).
 * Composition kit Pilot B: R8 slim banner → H1 · R7 empty (one primary recovery).
 */
export function StubProgrammeView({ feed }: Props) {
  useEffect(() => {
    applyProgrammeTheme(feed.event)
  }, [feed.event])

  const reason = feed.stub_reason?.trim() || DEFAULT_STUB

  return (
    <div className="min-h-screen pb-16">
      <header
        className="relative z-30 animate-rise border-b border-ink/10 bg-paper-card/95 backdrop-blur"
        data-msr-section="S-spa-shell"
      >
        <div className="mx-auto flex max-w-3xl flex-col gap-[var(--msr-stack-gap)] px-4 py-5 sm:px-6">
          <div className="flex flex-wrap items-center justify-between gap-2">
            <a
              href={feed.site_url}
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
              {feed.event_page_url ? (
                <a
                  href={feed.event_page_url}
                  className="text-sm font-medium text-ink-muted underline-offset-2 hover:text-accent-light hover:underline"
                >
                  Hub event page
                </a>
              ) : null}
            </div>
          </div>

          <div
            className="msr-companion-banner rounded-sm border border-ink/15 bg-paper-mid/50 px-3 py-2 text-xs leading-snug text-ink-muted"
            role="note"
            data-msr-section="S-spa-banner"
          >
            <p>
              <span className="font-semibold text-ink">Portfolio companion demo</span>
              {' — '}
              Not an App Store product. Stub mode — no day-of session grid.
            </p>
          </div>

          <div>
            <p className="text-xs font-semibold uppercase tracking-[0.14em] text-accent-light">
              Companion demo
            </p>
            <h1 className="mt-[var(--msr-stack-gap-tight)] font-display text-3xl font-bold tracking-tight text-ink sm:text-4xl">
              {feed.title}
            </h1>
          </div>
        </div>
      </header>

      <main className="mx-auto max-w-3xl px-4 py-8 sm:px-6">
        <div
          className="msr-companion-stub rounded-sm border border-dashed border-ink/20 bg-paper-card p-8 text-center"
          data-mode="stub"
        >
          <h2 className="font-display text-xl font-bold text-ink">No session agenda</h2>
          <p className="mx-auto mt-3 max-w-lg text-sm leading-relaxed text-ink-muted">{reason}</p>
          <a
            href={feed.site_url}
            className="mt-6 inline-flex min-h-11 items-center rounded-sm bg-accent px-4 py-2.5 text-sm font-semibold text-on-accent hover:bg-accent-dark"
          >
            Programme website
          </a>
          {feed.event_page_url ? (
            <p className="mt-4 text-sm">
              <a
                href={feed.event_page_url}
                className="font-medium text-accent-light underline-offset-2 hover:underline"
              >
                Hub event page
              </a>
            </p>
          ) : null}
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
    </div>
  )
}
