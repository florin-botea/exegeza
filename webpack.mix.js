const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');

const path = require( 'path' );
const { styles } = require( '@ckeditor/ckeditor5-dev-utils' );
const ckregex = /ckeditor5-[^/\\]+[/\\]theme[/\\].+\.css$/;
const cksvgregex = /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/\\][^/\\]+\.svg$/;

Mix.listen('configReady', function(config) {
	const rules = config.module.rules;
	rules.forEach ( rule => {
		if (rule.test.toString() == /\.css$/.toString()) {
			rule.exclude = ckregex;
		}
		if (rule.test.toString() == /(\.(png|jpe?g|gif|webp)$|^((?!font).)*\.svg$)/.toString()) {
			rule.exclude = cksvgregex;
		}
		if (rule.test.toString() == /(\.(woff2?|ttf|eot|otf)$|font.*\.svg$)/.toString()) {
			rule.exclude = cksvgregex;
		}
	});
});

mix.webpackConfig({
	module: {
		rules: [
			{
				test: /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/\\][^/\\]+\.svg$/,

				use: [ 'raw-loader' ]
			},
			{
				test: /ckeditor5-[^/\\]+[/\\]theme[/\\].+\.css$/,
				use: [
					{
						loader: 'style-loader',
						options: {
							injectType: 'singletonStyleTag'
						}
					},
					{
						loader: 'postcss-loader',
						options: styles.getPostCssConfig( {
							themeImporter: {
								themePath: require.resolve( '@ckeditor/ckeditor5-theme-lark' )
							},
							// minify: true
						})
					}
				]
			}
		]
	},

	// Useful for debugging.
	devtool: 'source-map',

	// By default webpack logs warnings if the bundle is bigger than 200kb.
	performance: { hints: false }
});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
	//.js('resources/js/ckeditor-classic.js', 'public/js')
	.sass('resources/sass/app.scss', 'public/css/app.css')
    .options({
        postCss: [ tailwindcss() ],
    });