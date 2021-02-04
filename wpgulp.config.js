/**
 * WPGulp Configuration File
 *
 * 1. Edit the variables as per your project requirements.
 * 2. In paths you can add <<glob or array of globs>>.
 *
 * @package WPGulp
 */

module.exports = {

	// Project options.
	projectURL: 'http://localhost/sulejowek', // Local project URL of your already running WordPress site. Could be something like wpgulp.local or localhost:3000 depending upon your local WordPress setup.
	productURL: './', // Theme/Plugin URL. Leave it like it is, since our gulpfile.js lives in the root folder.
	browserAutoOpen: true,
	injectChanges: true,

	// Style options.
	styleSRC: './src/style.scss', // Path to main .scss file.
	styleDestination: './', // Path to place the compiled CSS file. Default set to root folder.
	outputStyle: 'compact', // Available options → 'compact' or 'compressed' or 'nested' or 'expanded'
	errLogToConsole: true,
	precision: 10,

	// JS Vendor options.
	jsVendorSRC: './src/js/vendor/*.js', // Path to JS vendor folder.
	jsVendorDestination: './js/', // Path to place the compiled JS vendors file.
	jsVendorFile: 'vendor', // Compiled JS vendors file name. Default set to vendors i.e. vendors.js.

	// JS Custom options.
	jsCustomSRC: './src/js/*.js', // Path to JS custom scripts folder.
	jsCustomDestination: './js/', // Path to place the compiled JS custom scripts file.
	jsCustomFile: 'scripts', // Compiled JS custom file name. Default set to custom i.e. custom.js.

	// Images options.
	imgSRC: './src/img/**/*', // Source folder of images which should be optimized and watched. You can also specify types e.g. raw/**.{png,jpg,gif} in the glob.
	imgDST: './img/', // Destination folder of optimized images. Must be different from the imagesSRC folder.
    
    // Fonts options.
    fontSRC: './src/fonts/**/*.ttf',
    fontDST: './fonts/',

	// Watch files paths.
	watchStyles: './src/scss/**/*.scss', // Path to all *.scss files inside css folder and inside them.
	watchJsVendor: './src/js/vendor/*.js', // Path to all vendor JS files.
	watchJsCustom: './src/js/*.js', // Path to all custom JS files.
	watchPhp: './*.php',
	watchPhpParts: './parts/**/*.php',

	// Translation options.
	textDomain: 'sul', // Your textdomain here.
	translationFile: 'pl_PL.pot', // Name of the translation file.
	translationDestination: './languages', // Where to save the translation files.
	packageName: 'sul', // Package name.
	bugReport: 'https://lukaszgrochowski.com', // Where can users report bugs.
	lastTranslator: 'Łukasz Grochowski <mail@lukaszgrochowski.com>', // Last translator Email ID.
	team: 'Łukasz Grochowski <mail@lukaszgrochowski.com>', // Team's Email ID.

	// Browsers you care about for autoprefixing. Browserlist https://github.com/ai/browserslist
	// The following list is set as per WordPress requirements. Though, Feel free to change.
	BROWSERS_LIST: [
		'last 4 version',
		'> 1%',
		'ie >= 11',
		'last 6 Android versions',
		'last 6 ChromeAndroid versions',
		'last 5 Chrome versions',
		'last 5 Firefox versions',
		'last 4 Safari versions',
		'last 5 iOS versions',
		'last 4 Edge versions',
		'last 4 Opera versions'
	]
};
