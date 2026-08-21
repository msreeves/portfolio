import {
  EventCompanionFeedSchema,
  isKnownEvent,
  type EventCompanionFeed,
  type KnownEvent,
} from './schema'

export class UnknownEventError extends Error {
  readonly event: string
  constructor(event: string) {
    super(`Unknown event: ${event}`)
    this.name = 'UnknownEventError'
    this.event = event
  }
}

export class FeedLoadError extends Error {
  constructor(message: string, options?: { cause?: unknown }) {
    super(message, options)
    this.name = 'FeedLoadError'
  }
}

export function readEventParam(search = window.location.search): string {
  const raw = new URLSearchParams(search).get('event')
  const event = (raw || 'msrseminars').trim().toLowerCase()
  return event || 'msrseminars'
}

export function assertKnownEvent(event: string): KnownEvent {
  if (!isKnownEvent(event)) {
    throw new UnknownEventError(event)
  }
  return event
}

export async function loadFeed(event: KnownEvent): Promise<EventCompanionFeed> {
  const url = `${import.meta.env.BASE_URL}data/${event}.json`
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
  const parsed = EventCompanionFeedSchema.safeParse(json)
  if (!parsed.success) {
    throw new FeedLoadError(`Invalid feed shape: ${parsed.error.message}`)
  }
  return parsed.data
}
