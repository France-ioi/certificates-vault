var path = require('path');
var webpack = require('webpack');
var UglifyPlugin = require('uglifyjs-webpack-plugin');
var MiniCssExtractPlugin = require("mini-css-extract-plugin");
var OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
var BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

module.exports = function(env) {
    var production = process.env.NODE_ENV === 'production';

    var plugins = [
        /*
        new webpack.ProvidePlugin({
            '$': 'jquery',
            'jQuery': 'jquery',
            'window.jQuery': 'jquery',
            'window.$': 'jquery'
        }),
        */
        new MiniCssExtractPlugin({
            filename: "[name].css",
        }),
        new OptimizeCssAssetsPlugin({
            cssProcessor: require('cssnano'),
            cssProcessorPluginOptions: {
              preset: ['default', { discardComments: { removeAll: true } }],
            },
            canPrint: true
        }),
        //new BundleAnalyzerPlugin()
    ];

    if(production) {
        plugins.push(
            new UglifyPlugin({
                //sourceMap: true,
                parallel: true
            })
        )
    }

    return {
        devtool: production ? false : 'cheap-module-source-map',
        entry: {
            app: './resources/app_src/js/app.js'
        },
        watchOptions: {
            ignored: [
                /node_modules/
            ],
        },
        output: {
            path: path.resolve(__dirname, 'public/assets'),
            filename: '[name].js'
        },
        plugins: plugins,
        optimization: {
            splitChunks: {
                cacheGroups: {
                    vendor: {
                        test: /[\\/]node_modules[\\/]/,
                        name: 'vendor',
                        chunks: 'all'
                    }
                }
            }
        },
        module: {
            rules: [
                {
                    test: /\.(css)$/,
                    use: [
                        {
                            loader: MiniCssExtractPlugin.loader
                        },
                        'css-loader'
                    ]
                },
                {
                    test: /\.(png|jpg|gif)$/,
                    loader: 'file-loader?name=images/[name].[ext]'
                },
                {
                    test: /\.(eot|svg|ttf|woff|woff2)$/,
                    loader: 'file-loader?name=fonts/[name].[ext]'
                },
                {
                    test: /\.html$/,
                    use: [
                        {
                            loader: 'ngtemplate-loader',
                            options: {
                                relativeTo: path.resolve(__dirname, 'resources/app_src/templates')
                            }
                        },
                        'html-loader'
                    ]

                }
            ]
        }
    }
};