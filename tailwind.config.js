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
        },
        red: {
          '100': '#FFF5F5',
          '200': '#FED7D7',
          '300': '#FEB2B2',
          '400': '#FC8181',
          '500': '#F56565',
          '600': '#ee0000',
          '700': '#C53030',
          '800': '#9B2C2C',
          '900': '#742A2A',
        }
      },
      borderColor: theme => ({
        default: theme('colors.gray.200', 'currentColor'),
      }),
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
