const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .sourceMaps(); // Enable source maps

// Add more mix configurations as needed

if (mix.inProduction()) {
    mix.version(); // Enable versioning for cache busting in production
}
