import { useEffect, useMemo, useState } from 'react'

import { ProductCard } from '@/components/ProductCard'
import { FeedLoadError, loadProductFeed } from '@/lib/feed'
import type { ProductCompanionFeed } from '@/lib/schema'
import { applyProductTheme } from '@/lib/theme'

export default function App() {
  const [feed, setFeed] = useState<ProductCompanionFeed | null>(null)
  const [error, setError] = useState<Error | null>(null)
  const [loading, setLoading] = useState(true)
  const [query, setQuery] = useState('')
  const [category, setCategory] = useState('all')

  useEffect(() => {
    applyProductTheme()
  }, [])

  useEffect(() => {
    let cancelled = false
    ;(async () => {
      setLoading(true)
      setError(null)
      try {
        const data = await loadProductFeed()
        if (!cancelled) setFeed(data)
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

  const categories = useMemo(() => {
    if (!feed) return []
    const set = new Set<string>()
    for (const p of feed.products) {
      if (p.category) set.add(p.category)
    }
    return [...set].sort((a, b) => a.localeCompare(b))
  }, [feed])

  const filtered = useMemo(() => {
    if (!feed) return []
    const q = query.trim().toLowerCase()
    return feed.products.filter((p) => {
      if (category !== 'all' && p.category !== category) return false
      if (!q) return true
      return (
        p.title.toLowerCase().includes(q) ||
        p.sku.toLowerCase().includes(q) ||
        p.category.toLowerCase().includes(q)
      )
    })
  }, [feed, query, category])

  if (loading) {
    return (
      <main
        className="mx-auto max-w-6xl px-4 py-16 text-ink-muted"
        aria-busy="true"
        aria-live="polite"
      >
        Loading catalogue…
      </main>
    )
  }

  if (error || !feed) {
    return (
      <main className="mx-auto max-w-lg px-4 py-16">
        <h1 className="font-display text-2xl font-bold text-ink">Couldn’t load catalogue</h1>
        <p className="mt-2 text-sm text-ink-muted">
          {error instanceof FeedLoadError ? error.message : 'Unexpected error.'}
        </p>
        <a
          href={feed?.site_url ?? './'}
          className="mt-6 inline-flex min-h-11 items-center rounded-sm border border-ink/15 bg-paper-card px-4 py-2.5 text-sm font-semibold text-ink"
        >
          Back to website
        </a>
      </main>
    )
  }

  const chipSelected = 'bg-accent text-on-accent'
  const chipIdle = 'bg-paper-card text-ink shadow-soft hover:bg-paper-mid'

  return (
    <div className="min-h-screen pb-16">
      <header
        className="border-b border-ink/10 bg-paper-card/95 backdrop-blur"
        data-msr-section="S-spa-shell"
      >
        <div className="mx-auto flex max-w-6xl flex-col gap-4 px-4 py-4 sm:px-6">
          <div className="flex flex-wrap items-center justify-between gap-2">
            <a
              href={feed.site_url}
              className="inline-flex min-h-11 items-center gap-1.5 rounded-sm border border-ink/15 bg-paper px-3 py-2 text-sm font-semibold text-ink transition hover:border-accent/40 hover:text-accent-light"
            >
              <span aria-hidden="true">←</span>
              Back to website
            </a>
            <a
              href={feed.shop_url}
              className="text-sm font-medium text-ink-muted underline-offset-2 hover:text-accent-light hover:underline"
            >
              Open shop
            </a>
          </div>
          <div
            className="rounded-sm border border-ink/15 bg-paper-mid/50 px-3 py-2 text-xs leading-snug text-ink-muted"
            role="note"
          >
            <span className="font-semibold text-ink">Portfolio catalogue companion</span>
            {' — '}
            Inquiry-first demo; SKU-matched imagery from the local Woo showcase.
          </div>
          <div>
            <h1 className="font-display text-3xl font-bold text-ink sm:text-4xl">{feed.title}</h1>
            <p className="mt-1 text-sm text-ink-muted">
              {filtered.length} of {feed.products.length} products
            </p>
          </div>
          <label className="block">
            <span className="sr-only">Search products</span>
            <input
              type="search"
              value={query}
              onChange={(e) => setQuery(e.target.value)}
              placeholder="Search by name or SKU"
              className="min-h-11 w-full max-w-md rounded-sm border border-ink/15 bg-paper px-3 py-2 text-sm text-ink"
            />
          </label>
          <div role="group" aria-label="Filter by category" className="flex flex-wrap gap-2">
            <button
              type="button"
              aria-pressed={category === 'all'}
              onClick={() => setCategory('all')}
              className={`min-h-10 shrink-0 rounded-sm px-3 py-2 text-sm font-semibold transition ${
                category === 'all' ? chipSelected : chipIdle
              }`}
            >
              All
            </button>
            {categories.map((c) => (
              <button
                key={c}
                type="button"
                aria-pressed={category === c}
                onClick={() => setCategory(c)}
                className={`min-h-10 shrink-0 rounded-sm px-3 py-2 text-sm font-semibold transition ${
                  category === c ? chipSelected : chipIdle
                }`}
              >
                {c}
              </button>
            ))}
          </div>
        </div>
      </header>

      <main className="mx-auto max-w-6xl px-4 py-8 sm:px-6">
        {filtered.length === 0 ? (
          <p className="rounded-sm border border-dashed border-ink/20 bg-paper-card/60 p-8 text-center text-ink-muted">
            No products match this filter.
          </p>
        ) : (
          <ul className="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            {filtered.map((product) => (
              <li key={product.id}>
                <ProductCard product={product} />
              </li>
            ))}
          </ul>
        )}
      </main>

      <footer className="mx-auto max-w-6xl px-4 sm:px-6">
        <p className="rounded-sm border border-ink/10 bg-paper-mid/60 px-4 py-3 text-xs leading-relaxed text-ink-muted">
          {feed.disclaimer}
        </p>
        <p className="mt-4 text-center text-xs text-ink-muted">
          <a href={feed.contact_url} className="font-medium text-accent-light hover:underline">
            Contact
          </a>
          {' · '}
          Michael Reeves portfolio demo
        </p>
      </footer>
    </div>
  )
}
