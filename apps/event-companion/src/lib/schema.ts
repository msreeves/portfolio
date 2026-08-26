import { z } from 'zod'

export const DelegatePhaseSchema = z.enum(['registration', 'during', 'replay'])

export const TrackSchema = z.object({
  id: z.string().min(1),
  label: z.string().min(1),
  agenda_post_id: z.number().int().positive().optional(),
  day: z.string().min(1),
})

export const SessionSchema = z.object({
  id: z.string().min(1),
  track: z.string().min(1),
  title: z.string().min(1),
  format: z.string().min(1),
  starts_at: z.string().min(1),
  ends_at: z.string().min(1),
  summary: z.string().optional().default(''),
  agenda_url: z.string().url().optional(),
})

/** `schedule` = session grid; `stub` = no agenda CPT (C1b Awards). */
export const FeedModeSchema = z.enum(['schedule', 'stub'])

export const EventCompanionFeedSchema = z
  .object({
    event: z.string().min(1),
    title: z.string().min(1),
    timezone: z.string().min(1),
    delegate_phase: DelegatePhaseSchema,
    companion_demo_url: z.string().min(1),
    booking_url: z.string().min(1),
    disclaimer: z.string().min(1),
    /** Programme home — primary exit from the SPA (C0). */
    site_url: z.string().url(),
    /** Hub event single — secondary exit (C0). */
    event_page_url: z.string().url().optional(),
    agenda_url: z.string().optional(),
    mode: FeedModeSchema.default('schedule'),
    demo_dates: z.array(z.string()).default([]),
    tracks: z.array(TrackSchema).default([]),
    sessions: z.array(SessionSchema).default([]),
    /** Why this feed is stub (shown on stub UI). */
    stub_reason: z.string().min(1).optional(),
  })
  .superRefine((data, ctx) => {
    if (data.mode !== 'schedule') return
    if (data.demo_dates.length < 1) {
      ctx.addIssue({
        code: z.ZodIssueCode.custom,
        message: 'schedule feeds need at least one demo_dates entry',
        path: ['demo_dates'],
      })
    }
    if (data.tracks.length < 1) {
      ctx.addIssue({
        code: z.ZodIssueCode.custom,
        message: 'schedule feeds need at least one track',
        path: ['tracks'],
      })
    }
    if (data.sessions.length < 1) {
      ctx.addIssue({
        code: z.ZodIssueCode.custom,
        message: 'schedule feeds need at least one session',
        path: ['sessions'],
      })
    }
  })

export type DelegatePhase = z.infer<typeof DelegatePhaseSchema>
export type Track = z.infer<typeof TrackSchema>
export type Session = z.infer<typeof SessionSchema>
export type FeedMode = z.infer<typeof FeedModeSchema>
export type EventCompanionFeed = z.infer<typeof EventCompanionFeedSchema>

/** Feeds with a loadable JSON file (schedule or stub). */
export const KNOWN_EVENTS = ['msrseminars', 'msrawards'] as const
export type KnownEvent = (typeof KNOWN_EVENTS)[number]

export function isKnownEvent(value: string): value is KnownEvent {
  return (KNOWN_EVENTS as readonly string[]).includes(value)
}

/** C1a — programme picker catalog (not a full event feed). */
export const CatalogStatusSchema = z.enum(['ready', 'coming_soon', 'stub'])

export const CatalogProgrammeSchema = z.object({
  id: z.string().min(1),
  title: z.string().min(1),
  blurb: z.string().min(1),
  status: CatalogStatusSchema,
  site_url: z.string().url(),
  event_page_url: z.string().url().optional(),
})

export const CompanionCatalogSchema = z.object({
  title: z.string().min(1),
  hub_events_url: z.string().url(),
  programmes: z.array(CatalogProgrammeSchema).min(1),
})

export type CatalogStatus = z.infer<typeof CatalogStatusSchema>
export type CatalogProgramme = z.infer<typeof CatalogProgrammeSchema>
export type CompanionCatalog = z.infer<typeof CompanionCatalogSchema>

/** Fallbacks when feed unknown / missing (local MAMP). */
export const HUB_EVENTS_URL = 'http://msrevents.local:8888/our-events/'
export const SEMINARS_HOME_URL = 'http://msrevents.local:8888/msrseminars/'
