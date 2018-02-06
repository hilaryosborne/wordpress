const webpack = require('webpack')
const merge = require('webpack-merge')
const UglifyJSPlugin = require('uglifyjs-webpack-plugin')
const common = require('./webpack.common.js')

const uglify = new UglifyJSPlugin({
  sourceMap: true
})

const inProduction = new webpack.DefinePlugin({
  'process.env.NODE_ENV': JSON.stringify('production')
})

module.exports = merge(common, {
  plugins: [uglify, inProduction]
})
