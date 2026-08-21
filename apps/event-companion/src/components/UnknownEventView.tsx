type Props = {
  event: string
}

export function UnknownEventView({ event }: Props) {
  return (
    <main className="mx-auto flex min-h-screen max-w-lg flex-col justify-center px-4 py-16">
      <p className="text-xs font-semibold uppercase tracking-[0.14em] text-teal-dark">
        Companion demo
      </p>
      <h1 className="mt-2 font-display text-3xl font-bold text-ink">Event not available</h1>
      <p className="mt-3 text-ink-muted">
        No schedule feed for <code className="rounded bg-ink/5 px-1.5 py-0.5 text-sm">{event}</code>
        .
      </p>
      <p className="mt-2 text-sm text-ink-muted">
        v1 supports <strong>MSR Seminars</strong> only. Awards will share this app later as a second
        mode.
      </p>
      <a
        className="mt-6 inline-flex min-h-11 w-fit items-center rounded-xl bg-teal px-4 py-2.5 text-sm font-semibold text-white hover:bg-teal-dark"
        href="?event=msrseminars"
      >
        Open Seminars companion
      </a>
    </main>
  )
}
