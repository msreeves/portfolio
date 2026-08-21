#!/usr/bin/env node
/**
 * Copy production build to the portfolio demo folder + SPA .htaccess.
 * Run from sites/portfolio/apps/event-companion:
 *   npm run ship:portfolio:local   # MAMP base
 *   npm run ship:portfolio         # prod base /projects/event-companion/
 */
import { cpSync, existsSync, mkdirSync, rmSync, writeFileSync } from 'node:fs'
import path from 'node:path'
import { fileURLToPath } from 'node:url'

const root = path.dirname(fileURLToPath(import.meta.url))
const projectRoot = path.resolve(root, '..')
const dist = path.join(projectRoot, 'dist')
const dest = path.resolve(projectRoot, '../../projects/event-companion')

const prodBase = '/projects/event-companion/'
const localBase = '/sites/portfolio/projects/event-companion/'
/** Match vite.config.ts: unset env → prod Hostinger path; local ship sets EVENT_COMPANION_BASE. */
const rewriteBase = process.env.EVENT_COMPANION_BASE || prodBase

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

console.log(`Shipped → ${dest}`)
console.log(`RewriteBase ${rewriteBase}`)
console.log(
  'Open http://127.0.0.1:8888/sites/portfolio/projects/event-companion/?event=msrseminars',
)
