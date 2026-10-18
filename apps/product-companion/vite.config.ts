import path from 'node:path'
import { defineConfig, loadEnv } from 'vite'
import react from '@vitejs/plugin-react'

/** Prod Hostinger path. Local: PRODUCT_COMPANION_BASE=/sites/portfolio/projects/product-companion/ */
const PROD_BASE = '/projects/product-companion/'

export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '')
  const localBase =
    process.env.PRODUCT_COMPANION_BASE || env.PRODUCT_COMPANION_BASE || PROD_BASE

  return {
    plugins: [react()],
    resolve: {
      alias: {
        '@': path.resolve(__dirname, './src'),
      },
    },
    base: mode === 'production' ? localBase : '/',
  }
})
