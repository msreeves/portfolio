/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        ink: {
          DEFAULT: '#14201c',
          muted: '#4a5c55',
        },
        paper: {
          DEFAULT: '#f4f7f5',
          card: '#ffffff',
        },
        teal: {
          DEFAULT: '#2aaa8a',
          dark: '#1e7d66',
          soft: '#d8f3ea',
        },
      },
      fontFamily: {
        display: ['"Source Serif 4"', 'Georgia', 'serif'],
        sans: ['"DM Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      boxShadow: {
        soft: '0 12px 40px rgba(20, 32, 28, 0.08)',
      },
    },
  },
  plugins: [],
}
