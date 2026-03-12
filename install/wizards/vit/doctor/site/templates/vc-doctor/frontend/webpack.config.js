const path = require('path')
const publicPath = '/assets/'
const assetsPath = `/..${publicPath}`
const webpack = require('webpack')
const CopyWebpackPlugin = require('copy-webpack-plugin')

const getEntries = () => {
	let entries = {
		app: './src/js/app.js',
	}
	return entries
}

module.exports = {
	entry: getEntries(),
	output: {
		path: path.resolve(__dirname + assetsPath),
		filename: 'js/[name].js',
		chunkFilename: 'js/[name].[chunkhash].js',
		// publicPath: `..${publicPath}`,
		clean: true,
	},
	resolve: {
		extensions: ['.js', '.jsx'],
	},
	module: {
		rules: [
			{
				test: /\.jsx$/,
				use: {
					loader: 'babel-loader',
					options: {
						exclude: /node_modules/,
						presets: ['@babel/react'],
					},
				},
			},
			{
				test: /\.js$/,
				use: {
					loader: 'babel-loader',
					options: {
						exclude: /node_modules/,
						presets: ['@babel/preset-env'],
					},
				},
			},
			{
				test: /\.woff2?|ttf$|otf$/i,
				loader: 'file-loader',
				options: {
					name: 'fonts/[name].[ext]',
				},
			},
			{
				test: /\.(png|jpe?g|svg|gif)$/i,
				loader: 'file-loader',
				options: {
					name: (fullPath) => {
						return fullPath.replace(/.*src\/img/, 'img')
					},
				},
			},
		],
	},
	plugins: [
		new webpack.ProgressPlugin(),
		new CopyWebpackPlugin({
			patterns: [
				{
					from: 'src/img',
					to: 'img',
				},
				{
					from: 'src/sass/fonts',
					to: 'css/fonts',
				},
				{
					from: 'src/json',
					to: 'json',
				},
			],
		}),
		// new webpack.ProvidePlugin({
		// 	$: 'jquery',
		// 	jQuery: 'jquery',
		// 	'window.jQuery': 'jquery',
		// }),
	],
	optimization: {
		// splitChunks: {
		// 	chunks: 'initial',
		// }
	},
}
