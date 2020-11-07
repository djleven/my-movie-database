require('dotenv').config()
const merge = require('webpack-merge')
const baseConfig = require('./webpack.config.common')

const webpack = require('webpack')
const host = "0.0.0.0"
const port = "8080"


module.exports = merge(baseConfig, {
    // mode: 'development', // for webpack 5.0.0
    output: {
        filename: process.env.JS_ASSETS_FOLDER + '/[name].js',
    },
    devServer: {
        publicPath: process.env.PUBLIC_PATH_TO_ASSETS_FOLDER,
        contentBase: false,
        hot: true,
        host: host,
        port: port,
        headers: {
            'Access-Control-Allow-Origin': '*'
        },
    },
    plugins: [
        new webpack.HotModuleReplacementPlugin(),
    ],
	devtool: false
})
