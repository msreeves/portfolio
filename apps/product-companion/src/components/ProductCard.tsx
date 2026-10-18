import { formatDisplayText, formatProductPrice } from '@/lib/format'
import type { ProductRow } from '@/lib/schema'

type Props = {
  product: ProductRow
}

export function ProductCard({ product }: Props) {
  const hasImage = product.image_url.trim().length > 0

  return (
    <article
      className="flex flex-col overflow-hidden rounded-sm border border-ink/10 bg-paper-card shadow-soft"
      data-msr-section="S-product-card"
    >
      <a href={product.product_url} className="block aspect-[4/3] bg-paper-mid">
        {hasImage ? (
          <img
            src={product.image_url}
            alt=""
            loading="lazy"
            decoding="async"
            className="h-full w-full object-contain p-3"
          />
        ) : (
          <div className="flex h-full items-center justify-center text-xs text-ink-muted">
            No image
          </div>
        )}
      </a>
      <div className="flex flex-1 flex-col gap-2 p-4">
        {product.category ? (
          <p className="text-xs font-semibold uppercase tracking-wide text-ink-muted">
            {formatDisplayText(product.category)}
          </p>
        ) : null}
        <h2 className="font-display text-lg font-bold leading-snug text-ink">
          <a href={product.product_url} className="hover:text-accent-light hover:underline">
            {formatDisplayText(product.title)}
          </a>
        </h2>
        <p className="text-sm text-ink-muted">
          <span className="font-mono text-xs">{product.sku}</span>
          {product.price ? <> · {formatProductPrice(product.price)}</> : null}
        </p>
        <div className="mt-auto flex flex-wrap gap-2 pt-2">
          <a
            href={product.product_url}
            className="inline-flex min-h-11 items-center rounded-sm bg-chrome px-4 py-2 text-sm font-semibold text-paper hover:opacity-90"
          >
            View on site
          </a>
          <a
            href={product.inquiry_url}
            className="inline-flex min-h-11 items-center rounded-sm border border-ink/15 px-4 py-2 text-sm font-semibold text-ink hover:border-accent/40"
          >
            Inquiry
          </a>
        </div>
      </div>
    </article>
  )
}
