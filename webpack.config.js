let Encore = require('@symfony/webpack-encore');

Encore
// directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')


    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    .addEntry('base', ['./assets/js/base.js', './assets/css/base.less'])
    .addEntry('scrollbar', './assets/css/scrollbar.less')

    .addEntry('partials/nav', ['./assets/js/partials/nav.js', './assets/css/partials/nav.less'])

    .addEntry('widget/masonry', './assets/css/widgets/masonry.less')
    .addEntry('widget/carousel', ['./assets/js/widgets/carousel.js', './assets/css/widgets/carousel.less'])

    .addEntry('episode/show', './assets/js/episode/episode.show.js')
    .addEntry('tag/index', ['./assets/js/tag/tag.index.js', './assets/css/tag/tag.index.less'])

    //search module
    .addEntry('search/tags', './assets/js/search/search.tag.js')

    .addStyleEntry('exception', './assets/css/exceptions/exception.less')

    .splitEntryChunks()
    .cleanupOutputBeforeBuild()

    .enableVersioning()
    .enableLessLoader()
    .enableSingleRuntimeChunk()
    .enableBuildNotifications(false)
    .enableSourceMaps(!Encore.isProduction())

    .configureBabel(() => {
    }, {
        useBuiltIns: 'usage',
        corejs: 3
    })

    .configureFilenames({
        css: 'assets/css/[contenthash].css',
        js: 'assets/js/[contenthash].js'
    })

    .addLoader({test: '/\.less$/', loader: 'less-loader'})
    .addLoader({test: /\.(png|jpg)$/, loader: 'url-loader'})

    //TODO - Wait for webpack-encore PR#675 to be merged to get optimization as a native encore setting
    .copyFiles({
        from: 'assets/images/',
        to: 'assets/images/[contenthash].[ext]',
        pattern: /\.(gif|jpe?g|tiff|png|webp|bmp)$/
    })
    .copyFiles({
        from: 'assets/images/',
        to: 'assets/icons/[contenthash].[ext]',
        pattern: /\.ico$/
    })
    .copyFiles({
        pattern: /\.(woff|woff2|eot|ttf|otf)$/,
        from: 'assets/fonts/',
        to: 'assets/fonts/[contenthash].[ext]'
    })
;

module.exports = Encore.getWebpackConfig();
