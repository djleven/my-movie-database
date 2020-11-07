'use strict'
require('dotenv').config()
const path = require('path')
const AssetsFolderPath =
	process.env.PATH_TO_BACKEND_ROOT_FROM_VUE_APP + process.env.PUBLIC_PATH_TO_ASSETS_FOLDER
const { VueLoaderPlugin } = require('vue-loader')

const fs = require('fs')
const util = require('util')
const readDir = util.promisify(fs.readdir)
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const isProduction = process.env.NODE_ENV === "production"

async function getEntriesFromFiles() {
	let files;
	let entryObject = {}
	const entriesFolder = './src/entries/'
	try {
		files = await readDir(entriesFolder);
	} catch (err) {
		console.log(err);
	}
	files.forEach(file => {
		entryObject[file.replace('.js', '')] = `${entriesFolder}${file}`
	})

	return entryObject
}

function getCssFilename() {

	if(isProduction) {
		return '/[name].min.css?[contenthash]'
	}

	return '/[name].css'
}

module.exports = {
	entry: () => getEntriesFromFiles(),
	output: {
		path: path.resolve(__dirname, AssetsFolderPath),
		publicPath: '.',
		library: [process.env.VUE_LIBRARY_NAME, '[name]'],
		libraryTarget: 'var',
	},
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: file => (
                    /node_modules/.test(file) &&
                    !/\.vue\.js/.test(file)
                )
            },
			{
				test: /\.css$/,
				use: [
					MiniCssExtractPlugin.loader,
					'css-loader'
				],
			},
            {
                test: /\.(png|jpg)$/,
                loader: 'file-loader',
                options: {
                    name: 'images/[name].[ext]?[hash]'
                }
            }
        ]
    },
	plugins: [
		new VueLoaderPlugin(),
		new MiniCssExtractPlugin({
			filename: process.env.CSS_ASSETS_FOLDER + getCssFilename(),
		}),
	],
	externals: {}
}
