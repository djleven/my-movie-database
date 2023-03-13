const { defineConfig } = require('@vue/cli-service')
require('dotenv').config()
const path = require('path')
const AssetsFolderPath =
    process.env.PATH_TO_BACKEND_ROOT_FROM_VUE_APP + process.env.PUBLIC_PATH_TO_ASSETS_FOLDER

module.exports = defineConfig({
  transpileDependencies: true,
  lintOnSave: false,
  publicPath: '.',
  outputDir: path.resolve(__dirname, AssetsFolderPath),
  configureWebpack: {
    output: {
      library: {
        name: [process.env.VUE_LIBRARY_NAME, '[name]'],
        type: 'var',
      },
    },
    optimization: {
      splitChunks: false
    },
  },
  filenameHashing: false,
})
