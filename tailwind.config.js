/** @type {import('tailwindcss').Config} */

import preset from './vendor/filament/support/tailwind.config.preset'
 

export default {
  presets: [preset],
  content: [
      './app/Filament/**/*.php',
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

