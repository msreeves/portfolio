/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        // Text on dark prestige (aligned with msrevents / msrawards / msrseminars)
        ink: {
          DEFAULT: '#f5f0ea',
          muted: '#a09888',
        },
        // Page + panel surfaces
        paper: {
          DEFAULT: '#0f0f0f',
          card: '#1a1a1a',
          mid: '#252525',
        },
        // Solid light chrome (selected chips, toast)
        chrome: {
          DEFAULT: '#f5f0ea',
          muted: '#a09888',
        },
        // Programme accent via CSS variables (hub / seminars / awards)
        accent: {
          DEFAULT: 'var(--msr-accent)',
          dark: 'var(--msr-accent-dark)',
          soft: 'var(--msr-accent-soft)',
          light: 'var(--msr-accent-light)',
        },
        'on-accent': 'var(--msr-on-accent)',
      },
      fontFamily: {
        display: ['"Playfair Display"', 'Georgia', 'serif'],
        sans: ['"DM Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      boxShadow: {
        soft: '0 12px 40px rgba(0, 0, 0, 0.45)',
      },
      borderRadius: {
        // Match WP theme 2px language for panels; keep sm/md for tap targets
        panel: '2px',
      },
    },
  },
  plugins: [],
}
