/** @type {import('tailwindcss').Config} */
export default {
  content: [],
  theme: {
    fontFamily: {
      sans: [ 'Montserrat', 'sans-serif' ],
      serif: [ 'Lora', 'serif' ],
    },

    extend: {
      colors: {
        dark: {
          primary: '#292A33',
          secondary: '#1B1C22',
        },
        light: {
          primary: '#F3EFF5',
        },
        accent: {
          primary: '#4EFFA6',
          secondary: '#5E2BFF',
        },
      }
    }
  },
  plugins: [],
}

