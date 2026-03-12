const path = require('path')
const webpack = require('webpack')
const { merge } = require('webpack-merge')
const config = require('./webpack.config')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')

module.exports = merge(config, {
	mode: 'production',
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
							sourceMap: false,
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
							sourceMap: false,
						},
					},
					{
						loader: 'postcss-loader',
						options: {
							sourceMap: false,
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
							implementation: require("dart-sass"),
						},
					},
				],
			},
		],
	},
	optimization: {
		minimize: true
	},
	plugins: [new MiniCssExtractPlugin({
		filename: "css/[name].css",
	})],
})
