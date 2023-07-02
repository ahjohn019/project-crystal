/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './vuejs/**/*.js',
    './vuejs/**/*.vue'
  ],
  theme: {
    extend: {}
  },
  plugins: [require('daisyui')]
}
