/**
 * Decode HTML entities in feed strings (legacy exports used &pound; in plain text).
 */
export function decodeHtmlEntities(value: string): string {
  if (!value || !value.includes('&')) {
    return value
  }
  if (typeof document !== 'undefined') {
    const el = document.createElement('textarea')
    el.innerHTML = value
    return el.value
  }
  return value
    .replace(/&pound;/gi, '£')
    .replace(/&euro;/gi, '€')
    .replace(/&nbsp;/gi, '\u00a0')
    .replace(/&amp;/g, '&')
    .replace(/&lt;/g, '<')
    .replace(/&gt;/g, '>')
    .replace(/&quot;/g, '"')
    .replace(/&#0*39;/g, "'")
}

export function formatProductPrice(price: string): string {
  const decoded = decodeHtmlEntities(price.trim())
  return decoded.replace(/\s+/g, ' ').trim()
}

/** Category / title lines from Woo JSON feed (legacy exports may contain entities). */
export function formatDisplayText(value: string): string {
  return decodeHtmlEntities(value.trim()).replace(/\s+/g, ' ').trim()
}
