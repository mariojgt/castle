const mix = require('laravel-mix');
const path = require("path");

mix.webpackConfig({
    module: {
        rules: [
            // Add support for Vue ref sugar (let ref = $ref())
            {
                test: /\.vue$/,
                loader: "vue-loader",
                options: {
                    reactivityTransform: true,
                },
            },
            // Add support for <style lang="postcss"> blocks
            {
                test: /\.(postcss)$/,
                use: ["vue-style-loader", { loader: "css-loader", options: { importLoaders: 1 } }, "postcss-loader"],
            },
        ],
    },
});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// Normal javascript
mix.js('resources/vendor/Castle/js/app.js', 'public/vendor/Castle/js')
    .sourceMaps()
    .version();

// Vue js
mix.js('resources/vendor/Castle/js/vue.js', 'public/vendor/Castle/js')
    .vue({ version: 3 })
    .sourceMaps()
    .version();
const tailwindcss = require('tailwindcss')

mix.sass('resources/vendor/Castle/sass/app.scss', 'public/vendor/Castle/css')
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('tailwind.config.js')],
    });
