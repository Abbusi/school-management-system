/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Brand & UI colors
        primary: {
          DEFAULT: '#0F766E',      // Teal
          strong: '#0B5C56',       // Hover/Active
          tint: '#DCEFEC',         // Accent bg
        },
        brand: {
          mint: '#46B8A7',         // Logo & accents
        },
        // Neutrals (Cool Gray)
        bg: {
          page: '#F4F6F7',
          card: '#FFFFFF',
          subtle: '#EAEEEF',
        },
        border: {
          DEFAULT: '#D4DBDC',
        },
        text: {
          primary: '#18302C',
          secondary: '#5C6B68',
          tertiary: '#9AA7A4',
        },
        // Semantics
        success: {
          DEFAULT: '#16A34A',
          bg: '#E4F6EA',
          text: '#136A33',
        },
        danger: {
          DEFAULT: '#DC4640',
          bg: '#FCEAEA',
          text: '#7E1D1B',
        },
        warning: {
          DEFAULT: '#BA7517',
          bg: '#FAEEDA',
          text: '#633806',
        },
        info: {
          DEFAULT: '#2563EB',
          bg: '#E6EDFB',
          text: '#1B3A86',
        },
      },
      spacing: {
        'space-1': '4px',
        'space-2': '8px',
        'space-3': '12px',
        'space-4': '16px',
        'space-5': '20px',
        'space-6': '24px',
        'space-8': '32px',
        'space-12': '48px',
      },
      borderRadius: {
        sm: '8px',
        md: '12px',
        lg: '16px',
        pill: '20px',
      },
      fontFamily: {
        sans: [
          '-apple-system',
          'BlinkMacSystemFont',
          '"Segoe UI"',
          'Roboto',
          'Helvetica',
          'Arial',
          'sans-serif',
        ],
        mono: ['"SF Mono"', '"Fira Code"', 'monospace'],
      },
      fontWeight: {
        regular: '400',
        medium: '500',
      },
      borderWidth: {
        '0.5': '0.5px',
      },
    },
  },
  plugins: [],
}
