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

export const EventCompanionFeedSchema = z.object({
  event: z.string().min(1),
  title: z.string().min(1),
  timezone: z.string().min(1),
  delegate_phase: DelegatePhaseSchema,
  companion_demo_url: z.string().min(1),
  booking_url: z.string().min(1),
  disclaimer: z.string().min(1),
  demo_dates: z.array(z.string()).min(1),
  agenda_url: z.string().optional(),
  tracks: z.array(TrackSchema).min(1),
  sessions: z.array(SessionSchema).min(1),
})

export type DelegatePhase = z.infer<typeof DelegatePhaseSchema>
export type Track = z.infer<typeof TrackSchema>
export type Session = z.infer<typeof SessionSchema>
export type EventCompanionFeed = z.infer<typeof EventCompanionFeedSchema>

/** v1 allowlist — Awards stretch later */
export const KNOWN_EVENTS = ['msrseminars'] as const
export type KnownEvent = (typeof KNOWN_EVENTS)[number]

export function isKnownEvent(value: string): value is KnownEvent {
  return (KNOWN_EVENTS as readonly string[]).includes(value)
}
