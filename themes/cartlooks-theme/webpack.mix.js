const mix = require('laravel-mix');
const path = require('path');

mix.webpackConfig({
    output: {
        publicPath: '/themes/cartlooks-theme/',
        chunkFilename: 'public/js/[name].js?id=[chunkhash]',
    },
    optimization: {
        splitChunks: {
            chunks: 'all',
        },
        minimize: true
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
});
mix.js('resources/js/main.js', 'public/js')
    .vue();