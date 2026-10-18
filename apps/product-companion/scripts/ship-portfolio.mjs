#!/usr/bin/env node
/**
 * Copy production build to the portfolio demo folder + SPA .htaccess.
 */
import { cpSync, existsSync, mkdirSync, readFileSync, readdirSync, rmSync, writeFileSync } from 'node:fs'
import path from 'node:path'
import { fileURLToPath } from 'node:url'

const root = path.dirname(fileURLToPath(import.meta.url))
const projectRoot = path.resolve(root, '..')
const dist = path.join(projectRoot, 'dist')
const dest = path.resolve(projectRoot, '../../projects/product-companion')
const programmeUrlsPath = path.resolve(projectRoot, '../../../../config/programme-urls.json')

const prodBase = '/projects/product-companion/'
const localBase = '/sites/portfolio/projects/product-companion/'
const rewriteBase = process.env.PRODUCT_COMPANION_BASE || prodBase
const isProdShip = rewriteBase === prodBase || rewriteBase === prodBase.replace(/\/$/, '')

if (!existsSync(dist)) {
  console.error('Missing dist/. Run `npm run build` first.')
  process.exit(1)
}

rmSync(dest, { recursive: true, force: true })
mkdirSync(dest, { recursive: true })
cpSync(dist, dest, { recursive: true })

const htaccess = `RewriteEngine On
RewriteBase ${rewriteBase.endsWith('/') ? rewriteBase : `${rewriteBase}/`}

RewriteCond %{REQUEST_FILENAME} -f [OR]
RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^ - [L]

RewriteRule ^ index.html [L]
`

writeFileSync(path.join(dest, '.htaccess'), htaccess, 'utf8')

function rewriteDataFeedsForProd() {
  if (!existsSync(programmeUrlsPath)) {
    console.error(`Missing ${programmeUrlsPath}`)
    process.exit(1)
  }
  const map = JSON.parse(readFileSync(programmeUrlsPath, 'utf8'))
  const props = map.properties || {}
  const pairs = []
  for (const key of ['products', 'productCompanion', 'portfolio']) {
    const row = props[key]
    if (!row?.local || !row?.prod) continue
    pairs.push([row.local.replace(/\/$/, ''), row.prod.replace(/\/$/, '')])
  }
  for (const alias of map.localAliases || []) {
    if (alias.local && alias.prod) {
      pairs.push([alias.local.replace(/\/$/, ''), alias.prod.replace(/\/$/, '')])
    }
  }
  pairs.push([
    'http://127.0.0.1/sites/portfolio/projects/product-companion',
    'https://www.msreeves.co.uk/projects/product-companion',
  ])
  pairs.sort((a, b) => b[0].length - a[0].length)

  const banned = map.bannedLiveSubstrings || ['127.0.0.1', 'localhost', 'msrevents.local', '']
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
  console.log('Local ship: feed URLs left as 127.0.0.1')
}

console.log(`Shipped → ${dest}`)
console.log(`RewriteBase ${rewriteBase}`)
if (isProdShip) {
  console.log('Open https://www.msreeves.co.uk/projects/product-companion/')
} else {
  console.log('Open http://127.0.0.1/sites/portfolio/projects/product-companion/')
}
