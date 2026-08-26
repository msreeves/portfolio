#!/usr/bin/env node
/**
 * Copy production build to the portfolio demo folder + SPA .htaccess.
 * Run from sites/portfolio/apps/event-companion:
 *   npm run ship:portfolio:local   # MAMP base + keep .local feed URLs
 *   npm run ship:portfolio         # Hostinger base + rewrite feeds to prod URLs
 *
 * After a prod ship, restore MAMP with ship:portfolio:local before local demos.
 */
import { cpSync, existsSync, mkdirSync, readFileSync, readdirSync, rmSync, writeFileSync } from 'node:fs'
import path from 'node:path'
import { fileURLToPath } from 'node:url'

const root = path.dirname(fileURLToPath(import.meta.url))
const projectRoot = path.resolve(root, '..')
const dist = path.join(projectRoot, 'dist')
const dest = path.resolve(projectRoot, '../../projects/event-companion')
const programmeUrlsPath = path.resolve(projectRoot, '../../../../config/programme-urls.json')

const prodBase = '/projects/event-companion/'
const localBase = '/sites/portfolio/projects/event-companion/'
/** Match vite.config.ts: unset env → prod Hostinger path; local ship sets EVENT_COMPANION_BASE. */
const rewriteBase = process.env.EVENT_COMPANION_BASE || prodBase
const isProdShip = rewriteBase === prodBase || rewriteBase === prodBase.replace(/\/$/, '')

if (!existsSync(dist)) {
  console.error('Missing dist/. Run `npm run build` first (or ship:portfolio which builds).')
  process.exit(1)
}

rmSync(dest, { recursive: true, force: true })
mkdirSync(dest, { recursive: true })
cpSync(dist, dest, { recursive: true })

const htaccess = `RewriteEngine On
RewriteBase ${rewriteBase.endsWith('/') ? rewriteBase : `${rewriteBase}/`}

# Serve existing files as-is (assets, favicon, data JSON).
RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]

# SPA fallback: client routes → index.html
RewriteRule ^ index.html [L]
`

writeFileSync(path.join(dest, '.htaccess'), htaccess, 'utf8')

/**
 * Rewrite companion JSON exit/CTA URLs for Hostinger (programme-urls.json).
 * Longer local prefixes first so /msrseminars wins over hub root.
 */
function rewriteDataFeedsForProd() {
  if (!existsSync(programmeUrlsPath)) {
    console.error(`Missing ${programmeUrlsPath} — cannot rewrite prod feed URLs.`)
    process.exit(1)
  }
  const map = JSON.parse(readFileSync(programmeUrlsPath, 'utf8'))
  const props = map.properties || {}
  const pairs = []
  for (const key of ['seminars', 'awards', 'events', 'eventCompanion', 'portfolio']) {
    const row = props[key]
    if (!row?.local || !row?.prod) continue
    pairs.push([row.local.replace(/\/$/, ''), row.prod.replace(/\/$/, '')])
  }
  // Path-style MAMP aliases
  for (const alias of map.localAliases || []) {
    if (alias.local && alias.prod) {
      pairs.push([alias.local.replace(/\/$/, ''), alias.prod.replace(/\/$/, '')])
    }
  }
  // Explicit companion + portfolio path variants used in feeds
  pairs.push([
    'http://127.0.0.1:8888/sites/portfolio/projects/event-companion',
    'https://www.msreeves.co.uk/projects/event-companion',
  ])
  pairs.sort((a, b) => b[0].length - a[0].length)

  const banned = map.bannedLiveSubstrings || ['127.0.0.1', 'localhost', 'msrevents.local', ':8888']
  const dataDir = path.join(dest, 'data')
  if (!existsSync(dataDir)) return

  for (const name of readdirSync(dataDir)) {
    if (!name.endsWith('.json')) continue
    const file = path.join(dataDir, name)
    let text = readFileSync(file, 'utf8')
    for (const [local, prod] of pairs) {
      text = text.split(local).join(prod)
    }
    for (const bad of banned) {
      if (text.includes(bad)) {
        console.error(`Prod ship blocked: ${name} still contains "${bad}" after URL rewrite.`)
        process.exit(1)
      }
    }
    writeFileSync(file, text, 'utf8')
    console.log(`Rewrote prod URLs → data/${name}`)
  }
}

if (isProdShip) {
  rewriteDataFeedsForProd()
  console.log('Prod ship: feed URLs rewritten via config/programme-urls.json')
} else {
  console.log('Local ship: feed URLs left as .local / 127.0.0.1')
}

console.log(`Shipped → ${dest}`)
console.log(`RewriteBase ${rewriteBase}`)
if (isProdShip) {
  console.log('Open https://www.msreeves.co.uk/projects/event-companion/')
  console.log('Restore MAMP after Hostinger upload: npm run ship:portfolio:local')
} else {
  console.log(
    'Open http://127.0.0.1:8888/sites/portfolio/projects/event-companion/?event=msrseminars',
  )
}
