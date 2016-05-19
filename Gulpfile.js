var gulp = require('gulp');
var sass = require('gulp-sass');
var sasslint = require('gulp-sass-lint');
var autoprefixer = require('autoprefixer');
var mqpacker = require('css-mqpacker');
var postcss = require('gulp-postcss');
var cssnano = require('gulp-cssnano');
var modernizr = require('gulp-modernizr');
var bump = require('gulp-bump');
var del = require('del');
var sort = require('gulp-sort');
var rename = require('gulp-rename');
var gutil = require('gulp-util');
var plumber = require('gulp-plumber');
var notify = require('gulp-notify');
var jshint = require('gulp-jshint');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var imagemin = require('gulp-imagemin');
var svgmin = require('gulp-svgmin');
var svgstore = require('gulp-svgstore');
var cheerio = require('gulp-cheerio');
var browserSync = require('browser-sync');
var reload = browserSync.reload;
var sourcemaps = require('gulp-sourcemaps');
var wpPot = require('gulp-wp-pot');

// Set assets paths.
var paths = {
	css: ['./*.css', '!*.min.css'],
	icons: 'assets/img/svg-icons/*.svg',
	images: ['assets/img/*', '!assets/img/*.svg'],
	php: ['./*.php', './**/*.php'],
	sass: 'assets/sass/**/*.scss',
	concat_scripts: [
	'assets/js/concat/*.js'
	// add any vendor assets as necessary
	],
	scripts: ['assets/js/*.js', '!assets/js/*.min.js', '!assets/js/customizer.js']
};

/**
 * Handle errors and alert the user.
 */
function handleErrors() {
	var args = Array.prototype.slice.call(arguments);

	notify.onError({
		title: 'Task Failed [<%= error.message %>',
		message: 'See console.',
		sound: 'Sosumi' // See: https://github.com/mikaelbr/node-notifier#all-notification-options-with-their-defaults
	}).apply(this, args);

	gutil.beep(); // Beep 'sosumi' again

	// Prevent the 'watch' task from stopping
	this.emit('end');
}

/**
 * Delete style.css and style.min.css before we minify and optimize
 */
gulp.task('clean:styles', function() {
	return del(['style.css', 'style.min.css'])
});

/**
 * Compile Sass and run stylesheet through PostCSS.
 *
 * https://www.npmjs.com/package/gulp-sass
 * https://www.npmjs.com/package/gulp-postcss
 * https://www.npmjs.com/package/gulp-autoprefixer
 * https://www.npmjs.com/package/css-mqpacker
 */
gulp.task('postcss', ['clean:styles'], function() {
	return gulp.src('assets/sass/*.scss', paths.css)

	// Deal with errors.
	.pipe(plumber({ errorHandler: handleErrors }))

	// Wrap tasks in a sourcemap.
	.pipe(sourcemaps.init())

		// Compile Sass using LibSass.
		.pipe(sass({
			errLogToConsole: true,
			outputStyle: 'expanded' // Options: nested, expanded, compact, compressed
		}))

		// Parse with PostCSS plugins.
		.pipe(postcss([
			autoprefixer({
				browsers: ['last 2 version']
			}),
			mqpacker({
				sort: true
			}),
		]))

	// Create sourcemap.
	.pipe(sourcemaps.write())

	// Create style.css.
	.pipe(gulp.dest('./'))
	.pipe(browserSync.stream());
});

/**
 * Minify and optimize style.css.
 *
 * https://www.npmjs.com/package/gulp-cssnano
 */
gulp.task('cssnano', ['postcss'], function() {
	return gulp.src('style.css')
	.pipe(plumber({ errorHandler: handleErrors }))
	.pipe(cssnano({
		safe: true // Use safe optimizations
	}))
	.pipe(rename('style.min.css'))
	.pipe(gulp.dest('./'))
	.pipe(browserSync.stream());
});

/**
 * Sass linting.
 *
 * https://www.npmjs.com/package/sass-lint
 */
gulp.task('sass:lint', ['cssnano'], function() {
	gulp.src([
		'assets/sass/**/*.scss'
	])
	.pipe(sassLint())
	.pipe(sassLint.format())
	.pipe(sassLint.failOnError());
});

/**
 * Optimize images.
 *
 * https://www.npmjs.com/package/gulp-imagemin
 */
gulp.task('imagemin', function() {
	return gulp.src(paths.images)
	.pipe(plumber({ errorHandler: handleErrors }))
	.pipe(imagemin({
		optimizationLevel: 5,
		progressive: true,
		interlaced: true
	}))
	.pipe(gulp.dest('assets/img'));
});

/**
 * Delete the svg-icons.svg before we minify, concat.
 */
gulp.task('clean:icons', function() {
	return del(['assets/images/svg-icons.svg']);
});

/**
 * Minify, concatenate, and clean SVG icons.
 *
 * https://www.npmjs.com/package/gulp-svgmin
 * https://www.npmjs.com/package/gulp-svgstore
 * https://www.npmjs.com/package/gulp-cheerio
 */
gulp.task('svg', ['clean:icons'], function() {
	return gulp.src(paths.icons)
	.pipe(plumber({ errorHandler: handleErrors }))
	.pipe(svgmin())
	.pipe(rename({ prefix: 'icon-' }))
	.pipe(svgstore({ inlineSvg: true }))
	.pipe(cheerio({
		run: function($, file) {
			$('svg').attr('style', 'display:none');
			$('[fill]').removeAttr('fill');
		},
		parserOptions: { xmlMode: true }
	}))
	.pipe(gulp.dest('assets/img/'))
	.pipe(browserSync.stream());
});

/**
 * Delete scripts before we concat and minify.
 */
gulp.task('clean:scripts', function() {
	return del(['assets/js/*.js']);
});

/**
 * Compile custom Modernizr build
 */
gulp.task('modernizr', function() {
  gulp.src(paths.concat_scripts)
    .pipe(modernizr({
			"options" : [
				"setClasses",
				"addTest",
				"html5printshiv",
				"testProp",
				"fnBind"
			]
    }))
    .pipe(gulp.dest('assets/js'))
});

/**
 * Bump version number in package.json, bower.json, and style.scss
 */
gulp.task('bump', function(){
  gulp.src(['./*.json', 'README.md', './*.css'])
  .pipe(bump())
  .pipe(gulp.dest('./'));
  gulp.src('assets/sass/style.scss')
  .pipe(bump())
  .pipe(gulp.dest('./assets/sass'));
});

// minor bumps
gulp.task('bump-minor', function(){
  gulp.src(['./*.json', 'README.md', './*.css'])
  .pipe(bump({type:'minor'}))
  .pipe(gulp.dest('./'));
  gulp.src('assets/sass/style.scss')
  .pipe(bump({type:'minor'}))
  .pipe(gulp.dest('./assets/sass'));
});

// major bumps
gulp.task('bump-major', function(){
  gulp.src(['./*.json', 'README.md', './*.css'])
  .pipe(bump({type:'major'}))
  .pipe(gulp.dest('./'));
  gulp.src('assets/sass/style.scss')
  .pipe(bump({type:'major'}))
  .pipe(gulp.dest('./assets/sass'));
});

/**
 * Concatenate javascripts after they're clobbered.
 * https://www.npmjs.com/package/gulp-concat
 */
gulp.task('concat', ['clean:scripts'], function() {
	return gulp.src(paths.concat_scripts)
	.pipe(plumber({ errorHandler: handleErrors }))
	.pipe(sourcemaps.init())
	.pipe(jshint())
	.pipe(jshint.reporter('fail'))
	.pipe(concat('project.js'))
	.pipe(sourcemaps.write())
	.pipe(gulp.dest('assets/js'))
	.pipe(browserSync.stream());
});

/**
  * Minify javascripts after they're concatenated.
  * https://www.npmjs.com/package/gulp-uglify
  */
gulp.task('uglify', ['concat'], function() {
	return gulp.src(paths.scripts)
	.pipe(rename({suffix: '.min'}))
	.pipe(uglify({
		mangle: false
	}))
	.pipe(gulp.dest('assets/js'));
});

/**
 * Delete the theme's .pot before we create a new one.
 */
gulp.task('clean:pot', function() {
	return del(['languages/bad-feather-nest.pot']);
});

/**
 * Scan the theme and create a POT file.
 *
 * https://www.npmjs.com/package/gulp-wp-pot
 */
gulp.task('wp-pot', ['clean:pot'], function() {
	return gulp.src(paths.php)
	.pipe(plumber({ errorHandler: handleErrors }))
	.pipe(sort())
	.pipe(wpPot({
		domain: 'nest',
		destFile:'bad-feather-nest.pot',
		package: 'bad-feather-nest',

	}))
	.pipe(gulp.dest('languages/'));
});

/**
 * Process tasks and reload browsers on file changes.
 *
 * https://www.npmjs.com/package/browser-sync
 */
gulp.task('watch', function() {

	// Kick off BrowserSync.
	browserSync({
		open: false,             // Open project in a new tab?
		injectChanges: true,     // Auto inject changes instead of full reload
		proxy: "nest.badfeather.local",  // This is assuming MAMP Pro or something similar is being used to host a local version of your site
		watchOptions: {
			debounceDelay: 1000  // Wait 1 second before injecting
		}
	});

	// Run tasks when files change.
	gulp.watch(paths.icons, ['icons']);
	gulp.watch(paths.sass, ['styles']);
	gulp.watch(paths.scripts, ['scripts']);
	gulp.watch(paths.concat_scripts, ['scripts']);
});

/**
 * Create individual tasks.
 */
gulp.task('i18n', ['wp-pot']);
gulp.task('icons', ['svg']);
gulp.task('scripts', ['uglify']);
gulp.task('styles', ['cssnano']);
gulp.task('default', ['i18n', 'modernizr', 'icons', 'styles', 'scripts', 'imagemin']);





