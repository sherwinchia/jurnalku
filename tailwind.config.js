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

    theme: {
        extend: {
          colors:{
            primary:{
              100:'#eaf3ff',
              200:'#cbe2ff',
              300:'#abd0ff',
              400:'#6dacff',
              500:'#2e89ff',
              600:'#297be6',
              700:'#2367bf',
              800:'#1c5299',
              900:'#17437d',
            },
            hover:'#ECEFF3',
            base:'#fcfdff',
            dark:{
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
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
