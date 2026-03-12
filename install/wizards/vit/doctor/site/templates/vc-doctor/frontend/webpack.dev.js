const path = require('path')
const webpack = require('webpack')
const {merge} = require('webpack-merge')
const config = require('./webpack.config')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')

module.exports = merge(config, {
	mode: 'development',
	watch: true,
	watchOptions: {
		ignored: /node_modules/,
	},
	module: {
		rules: [
			{
				test: /\.css$/,
				use: [
					{
						loader: MiniCssExtractPlugin.loader,
					},
					{
						loader: 'css-loader',
						options: {
							sourceMap: true,
						},
					},
				],
			},
			{
				test: /\.sass$/,
				include: path.resolve(__dirname, 'src/sass'),
				use: [
					{
						loader: MiniCssExtractPlugin.loader,
					},
					{
						loader: 'css-loader',
						options: {
							sourceMap: true,
						},
					},
					{
						loader: 'postcss-loader',
						options: {
							sourceMap: true,
							postcssOptions: {
								plugins: [
									[
										'postcss-preset-env',
										{
											browsers: 'last 5 versions',
										},
									],
								],
							},
						},
					},
					{
						loader: 'resolve-url-loader',
						options: {
							sourceMap: true,
						},
					},
					{
						loader: 'sass-loader',
						options: {
							sourceMap: true,
							implementation: require('dart-sass'),
						},
					},
				],
			},
		],
	},
	optimization: {
		minimize: false,
	},
	plugins: [new MiniCssExtractPlugin({
		filename: "css/[name].css",
	})],
})
