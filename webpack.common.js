const path = require('path')
const WebpackCleanupPlugin = require('webpack-cleanup-plugin')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const AssetsPlugin = require('assets-webpack-plugin')
const webpack = require('webpack')

const theme = 'boilerplate'

const extractSass = new ExtractTextPlugin({
  filename: 'css/[name].[hash].css',
  disable: process.env.NODE_ENV === 'development'
})

const assets = new AssetsPlugin({
  filename: 'manifest.json',
  path: path.resolve(`theme/dist/`),
  fullPath: false
})

const jquery = new webpack.ProvidePlugin({
  $: 'jquery',
  jQuery: 'jquery',
  jquery: 'jquery',
  'window.jQuery': 'jquery',
  Popper: ['popper.js', 'default']
})

const cleanup = new WebpackCleanupPlugin({
  exclude: ['manifest.json', 'fonts/**/*']
})

module.exports = {
  entry: './src/index',
  devtool: 'inline-sourcemap',
  output: {
    path: path.resolve(`theme/dist/`),
    filename: 'js/app.[chunkhash].js',
    publicPath: `/wp-content/themes/${theme}/dist/`
  },
  resolve: {
    extensions: ['.js', '.jsx', '.json']
  },
  module: {
    loaders: [
      {
        test: /\.json$/,
        loader: 'json-loader'
      },
      {
        enforce: 'pre',
        test: /\.js[x]?$/,
        exclude: /node_modules/,
        loader: 'eslint-loader'
      },
      {
        test: /\.js[x]?$/,
        loader: 'babel-loader',
        exclude: /node_modules/
      },
      {
        test: /\.scss|.css$/,
        use: extractSass.extract({
          use: [
            {
              loader: 'css-loader',
              options: {sourceMap: true}
            },
            {
              loader: 'sass-loader',
              options: {sourceMap: true}
            }
          ],
          fallback: 'style-loader'})
      },
      {
        test: /\.(jpg|jpeg|gif|png|svg)(\?.*$|$)/,
        exclude: [/node_modules/, /src\/fonts/],
        loader: 'url-loader?limit=1024&name=images/[name].[ext]'
      },
      {
        test: /\.(svg|woff|woff2|ttf|eot|otf)(\?.*$|$)/,
        exclude: [/src\/images/],
        loader: 'url-loader?limit=1024&name=fonts/[name].[ext]'
      }
    ]
  },
  plugins: [extractSass, jquery, cleanup, assets ]
}
