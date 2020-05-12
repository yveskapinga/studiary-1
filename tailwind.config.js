const _ = require('lodash')
const plugin = require('tailwindcss/plugin')

module.exports = {
  theme: {
    extend: {
      colors: {
        gray: {
          '100': '#fafafa',
          '200': '#eaeaea',
          '300': '#aaa',
          '400': '#999',
          '500': '#888',
          '600': '#666',
          '700': '#444',
          '800': '#222',
          '900': '#111'
        }
      },

      borderRadius: {
        default: '.3rem'
      }
    },
  },
  variants: {},
  plugins: [
    plugin(function ({ addUtilities }) {
      const containers = {
        '.container': {
          width: '90%',
          maxWidth: '980px',
          marginLeft: 'auto',
          marginRight: 'auto'
        }
      }

      addUtilities(containers, ['responsive'])
    })
  ],
}
