/** Programme visual themes — match MSR Events WP dark-prestige accents. */

export type ProgrammeThemeId = 'hub' | 'msrseminars' | 'msrawards'

export function resolveProgrammeTheme(eventSlug: string | null | undefined): ProgrammeThemeId {
  if (eventSlug === 'msrseminars') return 'msrseminars'
  if (eventSlug === 'msrawards') return 'msrawards'
  return 'hub'
}

/** Apply theme on <html> so CSS variables + color-scheme drive the shell. */
export function applyProgrammeTheme(eventSlug: string | null | undefined): void {
  const id = resolveProgrammeTheme(eventSlug)
  document.documentElement.dataset.programme = id
  const meta = document.querySelector('meta[name="theme-color"]')
  if (meta) {
    const accent =
      id === 'msrawards' ? '#c9a84c' : id === 'msrseminars' ? '#2aaa8a' : '#0e4c92'
    meta.setAttribute('content', accent)
  }
}
