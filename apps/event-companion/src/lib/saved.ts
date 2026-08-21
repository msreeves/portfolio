const STORAGE_KEY = 'event-companion-saved-v1'

export function loadSavedIds(event: string): string[] {
  try {
    const raw = localStorage.getItem(`${STORAGE_KEY}:${event}`)
    if (!raw) return []
    const parsed: unknown = JSON.parse(raw)
    if (!Array.isArray(parsed)) return []
    return parsed.filter((id): id is string => typeof id === 'string')
  } catch {
    return []
  }
}

export function persistSavedIds(event: string, ids: string[]): void {
  localStorage.setItem(`${STORAGE_KEY}:${event}`, JSON.stringify(ids))
}

export function toggleSavedId(event: string, id: string, current: string[]): string[] {
  const next = current.includes(id) ? current.filter((x) => x !== id) : [...current, id]
  persistSavedIds(event, next)
  return next
}
