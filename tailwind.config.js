const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: {
      enabled: process.env.NODE_ENV === 'production',
      content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
      ]
    },

    darkMode:"class",

    theme: {
        extend: {
          colors:{
            primary:{
              50: '#DEE2F6',
              100: '#CED4F2',
              200: '#AEB7E9',
              300: '#8E9BE0',
              400: '#6E7ED8',
              500: '#4e62cf',
              600: '#3145B4',
              700: '#253488',
              800: '#19235C',
              900: '#0D1230'
            },
            hover:'#ECEFF3',
            base:'#fcfdff',
            dark:{
              50:'#42464c',
              100:'#27292C',
              200:'#202125',
              300:'#15161A',
            },
            formhover:'#e7eff5',

          },
          fontFamily:{
            roboto:['Roboto','sans-serif']
          },
        },
      },

    variants: {
        textColor:['responsive', 'hover', 'focus', 'group-hover'],
        extend: {
            opacity: ['disabled'],
            textColor: ['dark'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
