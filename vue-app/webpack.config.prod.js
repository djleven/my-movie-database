require('dotenv').config()
const merge = require('webpack-merge')
const baseConfig = require('./webpack.config.common')
const path = require('path')
const AssetsFolderPath =
    process.env.PATH_TO_BACKEND_ROOT_FROM_VUE_APP + process.env.PUBLIC_PATH_TO_ASSETS_FOLDER

const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const AssetsPlugin = require('assets-webpack-plugin')
const { CleanWebpackPlugin } = require('clean-webpack-plugin')

module.exports = merge(baseConfig, {
    // mode: 'production', // for webpack 5.0.0
    output: {
		filename: process.env.JS_ASSETS_FOLDER + '/[name].min.js?[chunkhash]'
    },
    plugins: [
        new CleanWebpackPlugin(),
        new AssetsPlugin({
            filename: 'assets.json',
            path: path.resolve(__dirname, AssetsFolderPath),
            fullPath: false
        }),
    ]
})
