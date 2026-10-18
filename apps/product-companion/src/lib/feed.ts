import { ProductCompanionFeedSchema, type ProductCompanionFeed } from './schema'

export class FeedLoadError extends Error {
  constructor(message: string, options?: { cause?: unknown }) {
    super(message, options)
    this.name = 'FeedLoadError'
  }
}

export async function loadProductFeed(): Promise<ProductCompanionFeed> {
  const url = `${import.meta.env.BASE_URL}data/msrproducts.json`
  let res: Response
  try {
    res = await fetch(url)
  } catch (cause) {
    throw new FeedLoadError(`Could not fetch ${url}`, { cause })
  }
  if (!res.ok) {
    throw new FeedLoadError(`Feed HTTP ${res.status} for ${url}`)
  }
  const json: unknown = await res.json()
  const parsed = ProductCompanionFeedSchema.safeParse(json)
  if (!parsed.success) {
    throw new FeedLoadError(`Invalid feed shape: ${parsed.error.message}`)
  }
  return parsed.data
}
