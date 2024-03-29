const plugin = require('tailwindcss/plugin')

module.exports = {
    darkMode: 'class',
    mode: 'jit',
    purge: [
        // Path to my php view it will only purge stuf we goin to use
        "./vendor/mariojgt/castle/src/views/**/*.php",
        "./resources/vendor/Castle/js/**/*.vue",
    ],
    theme: {
      extend: {},
    },
    variants: {
        extend: {
          textOpacity: ['dark']
        }
    },
    plugins: [
        require('daisyui'),
        require('@tailwindcss/forms'),
    ],
  }
