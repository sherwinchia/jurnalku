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
              100:'#c4b492',
              200:'#baa880',
              300:'#b09b6d',
              400:'#a68f5b',
              500:'#9c8249',
              600:'#8c7542',
              700:'#7d683a',
              800:'#6d5b33',
              900:'#5e4e2c',
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
