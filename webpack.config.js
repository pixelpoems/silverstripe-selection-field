const Path = require("path");
const PATHS = {
    MODULES: 'node_modules',
    FILES_PATH: '../',
    ROOT: Path.resolve(),
    SRC: Path.resolve('client/src'),
    DIST: Path.resolve('client/dist'),
};

const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
    mode: 'production',
    target: 'web',
    entry: {
        "selection-field": [
            PATHS.SRC + '/scss/selection-field.scss',
            // PATHS.SRC + '/javascript/selection-field.js'
        ]
    },
    output: {
        filename: 'javascript/[name].min.js',
        path: PATHS.DIST,
        chunkFilename: 'javascript/[name].js',
        assetModuleFilename:  (pathData) => {
            // Add path to name if it's a flag-icon to avoid "Multiple assets emit to the same filename" error
            if(pathData.filename.startsWith('node_modules/@fortawesome/fontawesome-free/webfonts/')) return 'fonts/[name][ext]';
            return '[name][ext]';
        },
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/[name].min.css',
            chunkFilename: "[id].css"
        }),
    ],
    module: {
        rules: [
            {
                test: /\.(scss|css)$/,
                use: [
                    {
                        loader: 'style-loader'
                    },
                    {
                        loader: MiniCssExtractPlugin.loader,
                        options: {
                            esModule: false,
                        },
                    },
                    {
                        loader: 'css-loader',
                        options: {
                            sourceMap: true
                        }
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            postcssOptions: {
                                plugins: [
                                    [
                                        "postcss-preset-env",
                                        {
                                            // Options
                                        },
                                    ],
                                ],
                            },
                        },
                    },
                    {
                        loader: 'resolve-url-loader',
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: true
                        }
                    }
                ]
            },
            {
                test: /\.js$/,
                exclude: /(node_modules)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [
                            ['@babel/preset-env', { targets: "defaults" }]
                        ],
                    }
                }
            },
            {
                test: /\.(otf|woff|woff2|eot|ttf)$/,
                type: "asset/resource"
            },
        ]
    }
}
